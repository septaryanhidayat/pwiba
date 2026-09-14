<?php

namespace App\Services;

use App\Models\Letter;
use Illuminate\Support\Str;
use ZipArchive;

class DocumentConverterService
{
    /**
     * Parse uploaded document (DOCX, DOC, or PDF) and extract structured metadata and text.
     *
     * @return array<string, mixed>
     */
    public function parseDocument(string $filePath, string $originalExtension = 'docx', string $originalName = ''): array
    {
        $ext = strtolower($originalExtension);
        $rawText = '';

        if (in_array($ext, ['docx', 'doc'])) {
            $rawText = $this->parseDocx($filePath);
        } elseif ($ext === 'pdf') {
            $rawText = $this->parsePdf($filePath);
        } else {
            $rawText = @file_get_contents($filePath) ?: '';
        }

        return $this->extractMetadata($rawText, $originalName);
    }

    /**
     * Extract plain text and structure from a .docx file using native ZipArchive.
     */
    public function parseDocx(string $filePath): string
    {
        $zip = new ZipArchive;
        if ($zip->open($filePath) !== true) {
            return '';
        }

        $xmlContent = $zip->getFromName('word/document.xml');
        $zip->close();

        if (! $xmlContent) {
            return '';
        }

        return $this->cleanDocxXml($xmlContent);
    }

    /**
     * Convert document.xml tags into formatted plain text.
     */
    protected function cleanDocxXml(string $xmlContent): string
    {
        // Replace paragraph and break tags with newlines
        $text = preg_replace('/<w:p[^>]*>/i', "\n", $xmlContent);
        $text = preg_replace('/<w:br[^>]*>/i', "\n", $text);
        $text = preg_replace('/<w:cr[^>]*>/i', "\n", $text);
        $text = preg_replace('/<w:tab[^>]*>/i', "\t", $text);

        // Separate table cells with tab or pipe, rows with newline
        $text = preg_replace('/<\/w:tc>/i', " \t ", $text);
        $text = preg_replace('/<\/w:tr>/i', "\n", $text);

        // Strip remaining XML tags
        $text = strip_tags($text);

        // Decode XML/HTML entities
        $text = html_entity_decode($text, ENT_QUOTES | ENT_XML1, 'UTF-8');

        // Normalize multiple empty lines
        $text = preg_replace("/\n{3,}/", "\n\n", $text);

        return trim($text);
    }

    /**
     * Extract text from standard text-based PDF files using stream inspection.
     */
    public function parsePdf(string $filePath): string
    {
        $content = @file_get_contents($filePath);
        if (! $content) {
            return '';
        }

        $text = '';

        // Match BT ... ET blocks (Text objects in PDF)
        if (preg_match_all('/BT[\s\S]*?ET/m', $content, $matches)) {
            foreach ($matches[0] as $block) {
                // Match TJ or Tj operations
                if (preg_match_all('/\((.*?)\)\s*Tj/s', $block, $tjMatches)) {
                    $text .= implode(' ', $tjMatches[1])."\n";
                } elseif (preg_match_all('/\[(.*?)\]\s*TJ/s', $block, $tjMatches)) {
                    foreach ($tjMatches[1] as $arrayContent) {
                        if (preg_match_all('/\((.*?)\)/s', $arrayContent, $stringMatches)) {
                            $text .= implode('', $stringMatches[1]).' ';
                        }
                    }
                    $text .= "\n";
                }
            }
        }

        // Fallback or unescape PDF strings
        $text = str_replace(['\\(', '\\)', '\\\\'], ['(', ')', '\\'], $text);
        $text = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F]/', '', $text);

        return trim($text);
    }

    /**
     * Smart Extraction of document metadata from text.
     *
     * @return array<string, mixed>
     */
    public function extractMetadata(string $text, string $filename = ''): array
    {
        $meta = [
            'raw_text' => $text,
            'nomor_surat' => null,
            'tanggal' => date('Y-m-d'),
            'jenis_surat' => 'SURAT BIASA',
            'perihal' => null,
            'tujuan' => null,
            'nama_pejabat' => null,
            'jabatan_pejabat' => null,
            'tempat_tujuan' => 'Di Tempat',
            'alamat_tujuan' => null,
            'lampiran' => '1 (Satu) Berkas',
            'isi_surat' => $text,
        ];

        // 1. Detect Document Structure (Surat vs Proposal)
        $lowerText = strtolower($text.' '.$filename);
        $hasLetterGreeting = str_contains($lowerText, 'kepada yth') || str_contains($lowerText, 'dengan hormat');
        $hasLetterClosing = str_contains($lowerText, 'demikian surat') || str_contains($lowerText, 'hormat kami');
        $isLetterDocument = $hasLetterGreeting || $hasLetterClosing;

        $hasProposalStructure = (str_contains($lowerText, 'latar belakang') && str_contains($lowerText, 'tujuan kegiatan'))
            || str_contains($lowerText, 'rencana anggaran biaya')
            || str_contains($lowerText, 'susunan panitia');

        // Detect Jenis Surat
        if (str_contains($lowerText, 'surat perintah tugas') || str_contains($lowerText, 'surat tugas') || str_contains($lowerText, 'menugaskan kepada')) {
            $meta['jenis_surat'] = 'SURAT TUGAS';
            $meta['lampiran'] = '-';
        } elseif (str_contains($lowerText, 'audiensi') || str_contains($lowerText, 'audensi')) {
            $meta['jenis_surat'] = 'SURAT AUDENSI';
            $meta['lampiran'] = '1 (Satu) Berkas';
        } elseif (! $isLetterDocument && ($hasProposalStructure || str_starts_with(trim($lowerText), 'proposal') || str_contains($lowerText, 'proposal kegiatan'))) {
            // Strictly a PROPOSAL document
            $meta['jenis_surat'] = 'PROPOSAL';
            $meta['lampiran'] = 'RAB & Susunan Panitia';
        } else {
            // It is an OUTGOING LETTER (Surat Keluar / Surat Biasa)
            $meta['jenis_surat'] = 'SURAT BIASA';
            $meta['lampiran'] = str_contains($lowerText, 'proposal') ? '1 (satu) Berkas Proposal' : '1 (Satu) Berkas';
        }

        // 2. Extract Nomor Surat
        if (preg_match('/(?:Nomor|No)[\s.:]*([0-9]{1,4}\/[A-Za-z0-9\-]+\/[IVXLCDMivxlcdm]+\/[0-9]{4})/i', $text, $matches)) {
            $meta['nomor_surat'] = trim($matches[1]);
        } elseif (preg_match('/([0-9]{3,4}\/[A-Za-z0-9\-]+\/[IVXLCDMivxlcdm]+\/[0-9]{4})/i', $text, $matches)) {
            $meta['nomor_surat'] = trim($matches[1]);
        }

        // 3. Extract Perihal / Prihal / Hal
        if (preg_match('/(?:Perihal|Prihal|Hal)[\s.:]+([^\r\n]+)/i', $text, $matches)) {
            $rawPerihal = trim($matches[1]);
            // Strip markdown asterisks or underscores if present
            $rawPerihal = trim(str_replace(['**', '*', '__', '_'], '', $rawPerihal));
            $meta['perihal'] = $rawPerihal;
        } else {
            // Extract from intent in letter body
            if (preg_match('/(?:bermaksud|maksud kami)\s+mengajukan\s+(?:permohonan\s+)?([^\r\n.]+?)(?:\s+kepada|\s+guna|\s+dalam|\.)/i', $text, $matches)) {
                $rawIntent = trim($matches[1]);
                if (str_contains(strtolower($rawIntent), 'sponsorship') || str_contains(strtolower($rawIntent), 'kerjasama')) {
                    $meta['perihal'] = 'Permohonan Kerjasama / Sponsorship';
                } elseif (str_contains(strtolower($rawIntent), 'bantuan dana') || str_contains(strtolower($rawIntent), 'dana')) {
                    $meta['perihal'] = 'Permohonan Bantuan Dana';
                } elseif (str_contains(strtolower($rawIntent), 'audiensi')) {
                    $meta['perihal'] = 'Permohonan Audiensi';
                } else {
                    $meta['perihal'] = 'Permohonan '.ucwords($rawIntent);
                }
            } elseif (preg_match('/permohonan\s+(?:dukungan\s+)?kerjasama\s*\/\s*sponsorship/i', $text)) {
                $meta['perihal'] = 'Permohonan Kerjasama / Sponsorship';
            } elseif (preg_match('/permohonan\s+kerjasama/i', $text)) {
                $meta['perihal'] = 'Permohonan Kerjasama';
            } elseif (preg_match('/permohonan\s+sponsorship/i', $text)) {
                $meta['perihal'] = 'Permohonan Sponsorship';
            } elseif (preg_match('/permohonan\s+bantuan\s+dana/i', $text)) {
                $meta['perihal'] = 'Permohonan Bantuan Dana';
            } elseif (preg_match('/permohonan\s+audiensi/i', $text)) {
                $meta['perihal'] = 'Permohonan Audiensi';
            } elseif ($meta['jenis_surat'] === 'PROPOSAL') {
                if (preg_match('/(?:SEMINAR\s+SEHARI|KEGIATAN|PELATIHAN|TURNAMEN|WORKSHOP)[\s\S]*?["“]([^"”]+)["”]/i', $text, $matches)) {
                    $theme = trim($matches[1]);
                    if (str_contains($theme, ':')) {
                        $parts = explode(':', $theme);
                        $theme = trim($parts[0]);
                    }
                    $meta['perihal'] = 'Proposal Kegiatan Seminar Sehari: '.$theme;
                } elseif (str_contains(strtolower($text), 'jurnalisme cerdas')) {
                    $meta['perihal'] = 'Proposal Kegiatan Seminar Sehari: Jurnalisme Cerdas di Era AI';
                } elseif (preg_match('/^([^\r\n]{5,80})/m', trim($text), $matches)) {
                    $meta['perihal'] = 'Proposal: '.trim($matches[1]);
                } else {
                    $meta['perihal'] = 'Proposal Kegiatan';
                }
            }
        }

        // 4. Extract Lampiran (if explicitly stated)
        if (preg_match('/(?:Lampiran|Lamp)[\s.:]+([^\r\n]+)/i', $text, $matches)) {
            $meta['lampiran'] = trim($matches[1]);
        } elseif (preg_match('/(?:lampirkan|melampirkan)\s+([0-9]+\s*\([a-z0-9\s]+\)\s*berkas[^\r\n,.]*)/i', $text, $matches)) {
            $meta['lampiran'] = ucwords(trim($matches[1]));
        }

        // 5. Extract Kepada Yth / Tujuan
        if (preg_match('/(?:Kepada\s+Yth\.?|Yth\.?|Tujuan[\s.:]+)\s*([^\r\n]+)(?:\r?\n([^\r\n]+))?/i', $text, $matches)) {
            $tujuan1 = trim($matches[1]);
            $tujuan2 = isset($matches[2]) ? trim($matches[2]) : '';

            if ($tujuan1 && ! str_starts_with(strtolower($tujuan1), 'dengan hormat')) {
                $meta['tujuan'] = $tujuan1;
                if ($tujuan2 && ! str_starts_with(strtolower($tujuan2), 'di -') && ! str_starts_with(strtolower($tujuan2), 'jl') && ! str_starts_with(strtolower($tujuan2), 'dengan')) {
                    $meta['tujuan'] .= ' - '.$tujuan2;
                }
            }
        }

        // 6. Extract Alamat / Tempat
        if (preg_match('/(?:Jl\.?|Jalan)\s+([^\r\n]+)/i', $text, $matches)) {
            $meta['alamat_tujuan'] = 'Jl. '.trim($matches[1]);
        }
        if (preg_match('/(?:di\s*[-–:]*)\s*([^\r\n]+)/i', $text, $matches)) {
            $tempat = trim($matches[1]);
            if (! empty($tempat) && strlen($tempat) < 50) {
                $meta['tempat_tujuan'] = $tempat;
            }
        }

        // 7. Extract Tanggal (Indonesian months)
        $bulanMap = [
            'januari' => '01', 'februari' => '02', 'maret' => '03', 'april' => '04',
            'mei' => '05', 'juni' => '06', 'juli' => '07', 'agustus' => '08',
            'september' => '09', 'oktober' => '10', 'november' => '11', 'desember' => '12',
        ];
        if (preg_match('/([0-9]{1,2})\s+(Januari|Februari|Maret|April|Mei|Juni|Juli|Agustus|September|Oktober|November|Desember)\s+([0-9]{4})/i', $text, $matches)) {
            $day = str_pad($matches[1], 2, '0', STR_PAD_LEFT);
            $month = $bulanMap[strtolower($matches[2])] ?? '01';
            $year = $matches[3];
            $meta['tanggal'] = "{$year}-{$month}-{$day}";
        }

        // Fallback for perihal if still empty
        if (empty($meta['perihal'])) {
            $meta['perihal'] = $meta['jenis_surat'] === 'PROPOSAL' ? 'Proposal Kegiatan' : 'Surat Keluar Administrasi';
        }

        return $meta;
    }

    /**
     * Generate an official Microsoft Word (.docx) file from a Letter model.
     *
     * @return string Binary contents of the .docx file
     */
    public function generateDocx(Letter $letter): string
    {
        $tempZipPath = tempnam(sys_get_temp_dir(), 'pwi_letter_').'.docx';
        $zip = new ZipArchive;

        if ($zip->open($tempZipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new \RuntimeException('Gagal membuat berkas Word temporary.');
        }

        // 1. [Content_Types].xml
        $contentTypes = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
    <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
    <Default Extension="xml" ContentType="application/xml"/>
    <Default Extension="png" ContentType="image/png"/>
    <Override PartName="/word/document.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.document.main+xml"/>
    <Override PartName="/word/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.styles+xml"/>
</Types>';
        $zip->addFromString('[Content_Types].xml', $contentTypes);

        // 2. _rels/.rels
        $rootRels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
    <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="word/document.xml"/>
</Relationships>';
        $zip->addFromString('_rels/.rels', $rootRels);

        // 3. word/_rels/document.xml.rels
        $docRels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
    <Relationship Id="rIdStyles" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>
    <Relationship Id="rIdLogo" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/image" Target="media/image1.png"/>
</Relationships>';
        $zip->addFromString('word/_rels/document.xml.rels', $docRels);

        // 4. Logo image
        $logoPath = public_path('assets/images/pwi-logo.png');
        if (file_exists($logoPath)) {
            $zip->addFile($logoPath, 'word/media/image1.png');
        }

        // 5. word/styles.xml
        $stylesXml = $this->buildStylesXml();
        $zip->addFromString('word/styles.xml', $stylesXml);

        // 6. word/document.xml
        $documentXml = $this->buildDocumentXml($letter);
        $zip->addFromString('word/document.xml', $documentXml);

        $zip->close();

        $content = file_get_contents($tempZipPath);
        @unlink($tempZipPath);

        return $content;
    }

    /**
     * Build styles.xml for standard typography.
     */
    protected function buildStylesXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<w:styles xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">
    <w:docDefaults>
        <w:rPrDefault>
            <w:rPr>
                <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman" w:cs="Times New Roman"/>
                <w:sz w:val="23"/>
                <w:szCs w:val="23"/>
                <w:color w:val="000000"/>
            </w:rPr>
        </w:rPrDefault>
        <w:pPrDefault>
            <w:pPr>
                <w:spacing w:line="280" w:lineRule="auto" w:before="0" w:after="120"/>
            </w:pPr>
        </w:pPrDefault>
    </w:docDefaults>
</w:styles>';
    }

    /**
     * Build the OpenXML document body according to PWI Banyuasin standards.
     */
    protected function buildDocumentXml(Letter $letter): string
    {
        $isProposal = strtoupper($letter->jenis_surat) === 'PROPOSAL';
        $isTugas = strtoupper($letter->jenis_surat) === 'SURAT TUGAS';

        $bodyContent = '';

        // KOP SURAT RESMI
        $bodyContent .= $this->buildKopSuratXml();

        if ($isTugas) {
            $bodyContent .= $this->buildSuratTugasXml($letter);
        } elseif ($isProposal && str_contains(strtolower($letter->isi_surat ?? ''), 'latar belakang')) {
            $bodyContent .= $this->buildProposalFullXml($letter);
        } else {
            $bodyContent .= $this->buildSuratResmiXml($letter);
        }

        // TANDA TANGAN RESMI
        $bodyContent .= $this->buildTandaTanganXml($letter);

        // TEMBUSAN RESMI
        $bodyContent .= $this->buildTembusanXml($letter);

        // FOOTER KEABSAHAN QR
        $bodyContent .= $this->buildKeabsahanFooterXml($letter);

        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<w:document xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main"
            xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"
            xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing"
            xmlns:a="http://schemas.openxmlformats.org/drawingml/2006/main"
            xmlns:pic="http://schemas.openxmlformats.org/drawingml/2006/picture">
    <w:body>
        '.$bodyContent.'
        <w:sectPr>
            <w:pgSz w:w="11906" w:h="16838"/>
            <w:pgMar w:top="720" w:right="1020" w:bottom="1020" w:left="1020"/>
        </w:sectPr>
    </w:body>
</w:document>';
    }

    /**
     * Kop Surat PWI Banyuasin
     */
    protected function buildKopSuratXml(): string
    {
        return '
        <!-- Blue Box Table Kop Surat -->
        <w:tbl>
            <w:tblPr>
                <w:tblW w:w="10666" w:type="dxa"/>
                <w:tblInd w:w="-400" w:type="dxa"/>
                <w:tblCellMar>
                    <w:top w:w="0" w:type="dxa"/>
                    <w:left w:w="60" w:type="dxa"/>
                    <w:bottom w:w="0" w:type="dxa"/>
                    <w:right w:w="60" w:type="dxa"/>
                </w:tblCellMar>
                <w:tblBorders>
                    <w:top w:val="none"/><w:left w:val="none"/><w:bottom w:val="none"/><w:right w:val="none"/><w:insideH w:val="none"/><w:insideV w:val="none"/>
                </w:tblBorders>
                <w:shd w:val="clear" w:color="auto" w:fill="0B4DA2"/>
            </w:tblPr>
            <w:tblGrid>
                <w:gridCol w:w="1850"/>
                <w:gridCol w:w="8816"/>
            </w:tblGrid>
            <w:tr>
                <!-- Logo Cell: width 3.18cm, height 2.86cm -->
                <w:tc>
                    <w:tcPr>
                        <w:tcW w:w="1850" w:type="dxa"/>
                        <w:tcBorders>
                            <w:top w:val="none"/><w:left w:val="none"/><w:bottom w:val="none"/><w:right w:val="none"/>
                        </w:tcBorders>
                        <w:shd w:val="clear" w:color="auto" w:fill="0B4DA2"/>
                        <w:tcMar>
                            <w:top w:w="0" w:type="dxa"/>
                            <w:left w:w="60" w:type="dxa"/>
                            <w:bottom w:w="0" w:type="dxa"/>
                            <w:right w:w="60" w:type="dxa"/>
                        </w:tcMar>
                        <w:vAlign w:val="center"/>
                    </w:tcPr>
                    <w:p>
                        <w:pPr>
                            <w:jc w:val="center"/>
                            <w:spacing w:before="60" w:after="60" w:line="240" w:lineRule="auto"/>
                            <w:shd w:val="clear" w:color="auto" w:fill="0B4DA2"/>
                        </w:pPr>
                        <w:r>
                            <w:drawing>
                                <wp:inline distT="0" distB="0" distL="0" distR="0">
                                    <wp:extent cx="1144800" cy="1029600"/>
                                    <wp:effectExtent l="0" t="0" r="0" b="0"/>
                                    <wp:docPr id="1" name="Logo PWI"/>
                                    <wp:cNvGraphicFramePr>
                                        <a:graphicFrameLocks xmlns:a="http://schemas.openxmlformats.org/drawingml/2006/main" noChangeAspect="1"/>
                                    </wp:cNvGraphicFramePr>
                                    <a:graphic xmlns:a="http://schemas.openxmlformats.org/drawingml/2006/main">
                                        <a:graphicData uri="http://schemas.openxmlformats.org/drawingml/2006/picture">
                                            <pic:pic xmlns:pic="http://schemas.openxmlformats.org/drawingml/2006/picture">
                                                <pic:nvPicPr>
                                                    <pic:cNvPr id="0" name="pwi-logo.png"/>
                                                    <pic:cNvPicPr/>
                                                </pic:nvPicPr>
                                                <pic:blipFill>
                                                    <a:blip r:embed="rIdLogo"/>
                                                    <a:stretch>
                                                        <a:fillRect/>
                                                    </a:stretch>
                                                </pic:blipFill>
                                                <pic:spPr>
                                                    <a:xfrm>
                                                        <a:off x="0" y="0"/>
                                                        <a:ext cx="1144800" cy="1029600"/>
                                                    </a:xfrm>
                                                    <a:prstGeom prst="rect">
                                                        <a:avLst/>
                                                    </a:prstGeom>
                                                </pic:spPr>
                                            </pic:pic>
                                        </a:graphicData>
                                    </a:graphic>
                                </wp:inline>
                            </w:drawing>
                        </w:r>
                    </w:p>
                </w:tc>
                <!-- Text Cell: TNR 22pt, Arial 14pt, Arial 13pt, Arial 13pt -->
                <w:tc>
                    <w:tcPr>
                        <w:tcW w:w="8816" w:type="dxa"/>
                        <w:tcBorders>
                            <w:top w:val="none"/><w:left w:val="none"/><w:bottom w:val="none"/><w:right w:val="none"/>
                        </w:tcBorders>
                        <w:shd w:val="clear" w:color="auto" w:fill="0B4DA2"/>
                        <w:tcMar>
                            <w:top w:w="0" w:type="dxa"/>
                            <w:left w:w="60" w:type="dxa"/>
                            <w:bottom w:w="0" w:type="dxa"/>
                            <w:right w:w="60" w:type="dxa"/>
                        </w:tcMar>
                        <w:vAlign w:val="center"/>
                    </w:tcPr>
                    <w:p>
                        <w:pPr>
                            <w:jc w:val="right"/>
                            <w:spacing w:before="60" w:after="20" w:line="240" w:lineRule="auto"/>
                            <w:shd w:val="clear" w:color="auto" w:fill="0B4DA2"/>
                        </w:pPr>
                        <w:r>
                            <w:rPr>
                                <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman" w:cs="Times New Roman"/>
                                <w:b/>
                                <w:sz w:val="44"/>
                                <w:szCs w:val="44"/>
                                <w:color w:val="FFFFFF"/>
                                <w:spacing w:val="-2"/>
                            </w:rPr>
                            <w:t>PERSATUAN WARTAWAN INDONESIA</w:t>
                        </w:r>
                    </w:p>
                    <w:p>
                        <w:pPr>
                            <w:jc w:val="right"/>
                            <w:spacing w:before="0" w:after="20" w:line="240" w:lineRule="auto"/>
                            <w:shd w:val="clear" w:color="auto" w:fill="0B4DA2"/>
                        </w:pPr>
                        <w:r>
                            <w:rPr>
                                <w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/>
                                <w:b/>
                                <w:sz w:val="28"/>
                                <w:szCs w:val="28"/>
                                <w:color w:val="FFFFFF"/>
                            </w:rPr>
                            <w:t>PENGURUS KABUPATEN BANYUASIN</w:t>
                        </w:r>
                    </w:p>
                    <w:p>
                        <w:pPr>
                            <w:jc w:val="right"/>
                            <w:spacing w:before="0" w:after="10" w:line="220" w:lineRule="auto"/>
                            <w:shd w:val="clear" w:color="auto" w:fill="0B4DA2"/>
                        </w:pPr>
                        <w:r>
                            <w:rPr>
                                <w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/>
                                <w:sz w:val="26"/>
                                <w:szCs w:val="26"/>
                                <w:color w:val="FFFFFF"/>
                            </w:rPr>
                            <w:t>Central Executive Board</w:t>
                        </w:r>
                    </w:p>
                    <w:p>
                        <w:pPr>
                            <w:jc w:val="right"/>
                            <w:spacing w:before="0" w:after="60" w:line="220" w:lineRule="auto"/>
                            <w:shd w:val="clear" w:color="auto" w:fill="0B4DA2"/>
                        </w:pPr>
                        <w:r>
                            <w:rPr>
                                <w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/>
                                <w:b/>
                                <w:sz w:val="26"/>
                                <w:szCs w:val="26"/>
                                <w:color w:val="FFFFFF"/>
                            </w:rPr>
                            <w:t>INDONESIAN JOURNALIST\'S ASSOCIATION</w:t>
                        </w:r>
                    </w:p>
                </w:tc>
            </w:tr>
        </w:tbl>

        <!-- Address Paragraph: Arial 9pt, bold, centered, single line -->
        <w:p>
            <w:pPr>
                <w:ind w:left="-400" w:right="-400"/>
                <w:jc w:val="center"/>
                <w:spacing w:before="60" w:after="40" w:line="220" w:lineRule="auto"/>
            </w:pPr>
            <w:r>
                <w:rPr>
                    <w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/>
                    <w:b/>
                    <w:sz w:val="18"/>
                    <w:szCs w:val="18"/>
                    <w:color w:val="000000"/>
                    <w:spacing w:val="-3"/>
                    <w:w w:val="93"/>
                </w:rPr>
                <w:t>Jalan Merdeka NO 3 RT 02 RW 02 Kelurahan Mulya Agung Kecamatan Banyuasin III Kabupaten Banyuasin - Sumatera Selatan (30914)</w:t>
            </w:r>
        </w:p>

        <!-- Double Divider Line -->
        <w:p>
            <w:pPr>
                <w:ind w:left="-400" w:right="-400"/>
                <w:jc w:val="center"/>
                <w:spacing w:before="0" w:after="240" w:line="220" w:lineRule="auto"/>
                <w:pBdr>
                    <w:bottom w:val="double" w:sz="18" w:space="4" w:color="000000"/>
                </w:pBdr>
            </w:pPr>
        </w:p>';
    }

    /**
     * Standard formal letter layout.
     */
    protected function buildSuratResmiXml(Letter $letter): string
    {
        $nomor = htmlspecialchars($letter->nomor_surat ?? '-', ENT_XML1);
        $lampiran = htmlspecialchars($letter->lampiran ?? '1 (Satu) Berkas', ENT_XML1);
        $perihal = htmlspecialchars($letter->perihal ?? ($letter->keperluan ?? 'Surat Permohonan'), ENT_XML1);
        $tanggalFormatted = $letter->tanggal ? $letter->tanggal->translatedFormat('d F Y') : date('d F Y');
        $namaPejabat = htmlspecialchars($letter->nama_pejabat ?? '', ENT_XML1);
        $alamat = htmlspecialchars($letter->tempat_tujuan ?? ($letter->alamat_tujuan ?? 'Di Tempat'), ENT_XML1);

        $tujuanXml = '';
        foreach (explode("\n", str_replace(["\r\n", "\r"], "\n", $letter->tujuan ?? '')) as $tujLine) {
            $tujLine = trim($tujLine);
            if ($tujLine !== '') {
                $tujuanXml .= '<w:p><w:pPr><w:spacing w:before="0" w:after="20"/></w:pPr><w:r><w:b/><w:t>'.htmlspecialchars($tujLine, ENT_XML1).'</w:t></w:r></w:p>';
            }
        }

        $xml = '
        <w:tbl>
            <w:tblPr>
                <w:tblW w:w="9866" w:type="dxa"/>
                <w:tblBorders>
                    <w:top w:val="none"/><w:left w:val="none"/><w:bottom w:val="none"/><w:right w:val="none"/><w:insideH w:val="none"/><w:insideV w:val="none"/>
                </w:tblBorders>
            </w:tblPr>
            <w:tblGrid>
                <w:gridCol w:w="5600"/>
                <w:gridCol w:w="4266"/>
            </w:tblGrid>
            <w:tr>
                <w:tc>
                    <w:tcPr><w:tcW w:w="5600" w:type="dxa"/></w:tcPr>
                    <w:p><w:pPr><w:spacing w:before="0" w:after="30"/></w:pPr><w:r><w:t>Nomor    : '.$nomor.'</w:t></w:r></w:p>
                    <w:p><w:pPr><w:spacing w:before="0" w:after="30"/></w:pPr><w:r><w:t>Lampiran : '.$lampiran.'</w:t></w:r></w:p>
                    <w:p><w:pPr><w:spacing w:before="0" w:after="30"/></w:pPr><w:r><w:b/><w:t>Perihal    : '.$perihal.'</w:t></w:r></w:p>
                </w:tc>
                <w:tc>
                    <w:tcPr><w:tcW w:w="4266" w:type="dxa"/></w:tcPr>
                    <w:p><w:pPr><w:jc w:val="right"/><w:spacing w:before="0" w:after="30"/></w:pPr><w:r><w:t>Pangkalan Balai, '.$tanggalFormatted.'</w:t></w:r></w:p>
                </w:tc>
            </w:tr>
        </w:tbl>

        <w:p><w:pPr><w:spacing w:before="160" w:after="20"/></w:pPr><w:r><w:t>Kepada Yth.</w:t></w:r></w:p>
        '.$tujuanXml.'
        '.($namaPejabat && ! str_contains(strtolower($letter->tujuan ?? ''), strtolower($namaPejabat)) ? '<w:p><w:pPr><w:spacing w:before="0" w:after="20"/></w:pPr><w:r><w:b/><w:t>'.$namaPejabat.'</w:t></w:r></w:p>' : '').'
        <w:p><w:pPr><w:spacing w:before="0" w:after="20"/></w:pPr><w:r><w:t>di -</w:t></w:r></w:p>
        <w:p><w:pPr><w:ind w:left="360"/><w:spacing w:before="0" w:after="160"/></w:pPr><w:r><w:t>'.$alamat.'</w:t></w:r></w:p>

        <w:p><w:pPr><w:spacing w:before="180" w:after="100"/></w:pPr><w:r><w:t>Dengan hormat,</w:t></w:r></w:p>
        ';

        $paragraphs = explode("\n", str_replace(["\r\n", "\r"], "\n", $letter->isi_surat ?? ''));
        foreach ($paragraphs as $p) {
            $p = trim($p);
            if (! empty($p)) {
                $xml .= '
                <w:p>
                    <w:pPr>
                        <w:jc w:val="both"/>
                        <w:spacing w:before="60" w:after="140" w:line="300" w:lineRule="auto"/>
                    </w:pPr>
                    <w:r><w:t>'.htmlspecialchars($p, ENT_XML1).'</w:t></w:r>
                </w:p>';
            }
        }

        return $xml;
    }

    /**
     * Surat Tugas layout.
     */
    protected function buildSuratTugasXml(Letter $letter): string
    {
        $nomor = htmlspecialchars($letter->nomor_surat ?? '-', ENT_XML1);
        $namaMember = htmlspecialchars($letter->member->nama ?? ($letter->penandatangan_nama ?? 'Wardoyo, S.I.Kom'), ENT_XML1);
        $kta = htmlspecialchars($letter->member->nomor_kartu ?? '06.00.17208.14B', ENT_XML1);
        $jabatan = htmlspecialchars($letter->member->jabatan ?? 'Pengurus', ENT_XML1);
        $keperluan = htmlspecialchars($letter->keperluan ?? '-', ENT_XML1);
        $tujuan = htmlspecialchars($letter->tujuan ?? ($letter->lokasi ?? '-'), ENT_XML1);

        return '
        <w:p>
            <w:pPr>
                <w:jc w:val="center"/>
                <w:spacing w:before="180" w:after="60"/>
            </w:pPr>
            <w:r>
                <w:rPr><w:b/><w:u w:val="single"/><w:sz w:val="28"/></w:rPr>
                <w:t>SURAT PERINTAH TUGAS</w:t>
            </w:r>
        </w:p>
        <w:p>
            <w:pPr><w:jc w:val="center"/><w:spacing w:before="0" w:after="240"/></w:pPr>
            <w:r><w:t>Nomor: '.$nomor.'</w:t></w:r>
        </w:p>

        <w:p><w:r><w:t>Ketua Persatuan Wartawan Indonesia (PWI) Kabupaten Banyuasin dengan ini memberikan tugas kepada:</w:t></w:r></w:p>

        <w:tbl>
            <w:tblPr><w:tblW w:w="8500" w:type="dxa"/><w:tblBorders><w:top w:val="none"/><w:left w:val="none"/><w:bottom w:val="none"/><w:right w:val="none"/><w:insideH w:val="none"/><w:insideV w:val="none"/></w:tblBorders></w:tblPr>
            <w:tblGrid><w:gridCol w:w="2500"/><w:gridCol w:w="300"/><w:gridCol w:w="5700"/></w:tblGrid>
            <w:tr><w:tc><w:tcPr><w:tcW w:w="2500" w:type="dxa"/></w:tcPr><w:p><w:r><w:b/><w:t>Nama</w:t></w:r></w:p></w:tc><w:tc><w:tcPr><w:tcW w:w="300" w:type="dxa"/></w:tcPr><w:p><w:r><w:t>:</w:t></w:r></w:p></w:tc><w:tc><w:tcPr><w:tcW w:w="5700" w:type="dxa"/></w:tcPr><w:p><w:r><w:b/><w:t>'.$namaMember.'</w:t></w:r></w:p></w:tc></w:tr>
            <w:tr><w:tc><w:tcPr><w:tcW w:w="2500" w:type="dxa"/></w:tcPr><w:p><w:r><w:b/><w:t>Nomor KTA PWI</w:t></w:r></w:p></w:tc><w:tc><w:tcPr><w:tcW w:w="300" w:type="dxa"/></w:tcPr><w:p><w:r><w:t>:</w:t></w:r></w:p></w:tc><w:tc><w:tcPr><w:tcW w:w="5700" w:type="dxa"/></w:tcPr><w:p><w:r><w:t>'.$kta.'</w:t></w:r></w:p></w:tc></w:tr>
            <w:tr><w:tc><w:tcPr><w:tcW w:w="2500" w:type="dxa"/></w:tcPr><w:p><w:r><w:b/><w:t>Jabatan</w:t></w:r></w:p></w:tc><w:tc><w:tcPr><w:tcW w:w="300" w:type="dxa"/></w:tcPr><w:p><w:r><w:t>:</w:t></w:r></w:p></w:tc><w:tc><w:tcPr><w:tcW w:w="5700" w:type="dxa"/></w:tcPr><w:p><w:r><w:t>'.$jabatan.'</w:t></w:r></w:p></w:tc></w:tr>
        </w:tbl>

        <w:p><w:pPr><w:spacing w:before="180" w:after="100"/></w:pPr><w:r><w:t>Untuk melaksanakan tugas dan menghadiri:</w:t></w:r></w:p>

        <w:tbl>
            <w:tblPr><w:tblW w:w="8500" w:type="dxa"/><w:tblBorders><w:top w:val="none"/><w:left w:val="none"/><w:bottom w:val="none"/><w:right w:val="none"/><w:insideH w:val="none"/><w:insideV w:val="none"/></w:tblBorders></w:tblPr>
            <w:tblGrid><w:gridCol w:w="2500"/><w:gridCol w:w="300"/><w:gridCol w:w="5700"/></w:tblGrid>
            <w:tr><w:tc><w:tcPr><w:tcW w:w="2500" w:type="dxa"/></w:tcPr><w:p><w:r><w:b/><w:t>Keperluan Tugas</w:t></w:r></w:p></w:tc><w:tc><w:tcPr><w:tcW w:w="300" w:type="dxa"/></w:tcPr><w:p><w:r><w:t>:</w:t></w:r></w:p></w:tc><w:tc><w:tcPr><w:tcW w:w="5700" w:type="dxa"/></w:tcPr><w:p><w:r><w:t>'.$keperluan.'</w:t></w:r></w:p></w:tc></w:tr>
            <w:tr><w:tc><w:tcPr><w:tcW w:w="2500" w:type="dxa"/></w:tcPr><w:p><w:r><w:b/><w:t>Tujuan / Lokasi</w:t></w:r></w:p></w:tc><w:tc><w:tcPr><w:tcW w:w="300" w:type="dxa"/></w:tcPr><w:p><w:r><w:t>:</w:t></w:r></w:p></w:tc><w:tc><w:tcPr><w:tcW w:w="5700" w:type="dxa"/></w:tcPr><w:p><w:r><w:t>'.$tujuan.'</w:t></w:r></w:p></w:tc></w:tr>
        </w:tbl>

        <w:p><w:pPr><w:spacing w:before="240" w:after="180"/><w:jc w:val="both"/></w:pPr><w:r><w:t>Demikian Surat Perintah Tugas ini dibuat dan diberikan untuk dapat dipergunakan sebagaimana mestinya dan dilaksanakan dengan penuh rasa tanggung jawab.</w:t></w:r></w:p>';
    }

    /**
     * Proposal full multi-page document layout with headings & tables.
     */
    protected function buildProposalFullXml(Letter $letter): string
    {
        $judul = htmlspecialchars($letter->perihal ?? 'PROPOSAL KEGIATAN PWI BANYUASIN', ENT_XML1);

        $nomor = htmlspecialchars($letter->nomor_surat ?? '-', ENT_XML1);

        $xml = '
        <w:p>
            <w:pPr><w:jc w:val="center"/><w:spacing w:before="200" w:after="60"/></w:pPr>
            <w:r><w:rPr><w:b/><w:sz w:val="30"/></w:rPr><w:t>PROPOSAL KEGIATAN</w:t></w:r>
        </w:p>
        <w:p>
            <w:pPr><w:jc w:val="center"/><w:spacing w:before="0" w:after="60"/></w:pPr>
            <w:r><w:rPr><w:b/><w:sz w:val="24"/><w:color w:val="0B4DA2"/></w:rPr><w:t>'.$judul.'</w:t></w:r>
        </w:p>
        <w:p>
            <w:pPr><w:jc w:val="center"/><w:spacing w:before="0" w:after="240"/></w:pPr>
            <w:r><w:rPr><w:sz w:val="20"/><w:color w:val="475569"/></w:rPr><w:t>Nomor: '.$nomor.'</w:t></w:r>
        </w:p>';

        $content = $letter->isi_surat ?? '';
        if (preg_match('/<table[\s\S]*?<\/table>/i', $content, $tblMatch)) {
            $tableHtml = $tblMatch[0];
            $parts = explode($tableHtml, $content, 2);
            $xml .= $this->parseHtmlTextBlocks($parts[0]);
            $xml .= $this->convertHtmlTableToWordXml($tableHtml);
            $xml .= $this->parseHtmlTextBlocks($parts[1] ?? '');
        } else {
            $xml .= $this->parseHtmlTextBlocks($content);
        }

        return $xml;
    }

    /**
     * Parse text blocks with headings and bullets to Word XML.
     */
    protected function parseHtmlTextBlocks(string $html): string
    {
        $xml = '';
        $clean = preg_replace('/<\/(?:p|div|tr|li|h[1-6])>/i', "\n", $html);
        $clean = strip_tags(str_replace(['<br>', '<br/>', '<br />'], "\n", $clean));
        $clean = html_entity_decode($clean, ENT_QUOTES | ENT_XML1, 'UTF-8');

        $lines = explode("\n", str_replace(["\r\n", "\r"], "\n", $clean));
        foreach ($lines as $line) {
            $trimmed = trim($line);
            if (empty($trimmed)) {
                continue;
            }

            // Headings I., II., III. or A., B., C., etc.
            if (preg_match('/^(?:[IVXLCDMivxlcdm]+\.|[A-Z]\.)\s+/', $trimmed)) {
                $xml .= '
                <w:p>
                    <w:pPr><w:spacing w:before="240" w:after="80"/></w:pPr>
                    <w:r><w:rPr><w:b/><w:sz w:val="24"/></w:rPr><w:t>'.htmlspecialchars($trimmed, ENT_XML1).'</w:t></w:r>
                </w:p>';
            } elseif (str_starts_with($trimmed, '•') || str_starts_with($trimmed, '-')) {
                $xml .= '
                <w:p>
                    <w:pPr><w:ind w:left="400"/><w:spacing w:before="40" w:after="60"/></w:pPr>
                    <w:r><w:t>'.htmlspecialchars($trimmed, ENT_XML1).'</w:t></w:r>
                </w:p>';
            } else {
                $xml .= '
                <w:p>
                    <w:pPr><w:jc w:val="both"/><w:spacing w:before="60" w:after="100"/></w:pPr>
                    <w:r><w:t>'.htmlspecialchars($trimmed, ENT_XML1).'</w:t></w:r>
                </w:p>';
            }
        }

        return $xml;
    }

    /**
     * Convert HTML table into native Word XML table.
     */
    protected function convertHtmlTableToWordXml(string $tableHtml): string
    {
        $rows = [];
        $maxCols = 1;
        if (preg_match_all('/<tr[^>]*>([\s\S]*?)<\/tr>/i', $tableHtml, $rowMatches)) {
            foreach ($rowMatches[1] as $rowContent) {
                if (preg_match_all('/<(?:td|th)[^>]*>([\s\S]*?)<\/(?:td|th)>/i', $rowContent, $cellMatches)) {
                    $cellCount = count($cellMatches[1]);
                    if ($cellCount > $maxCols) {
                        $maxCols = $cellCount;
                    }
                    $rows[] = [
                        'isHeader' => str_contains($rowContent, '<th') || str_contains($rowContent, '<thead>'),
                        'cells' => $cellMatches[1],
                    ];
                }
            }
        }

        $totalWidth = 9866;
        $colWidth = (int) ($totalWidth / max(1, $maxCols));

        $gridXml = '<w:tblGrid>';
        for ($i = 0; $i < $maxCols; $i++) {
            $gridXml .= '<w:gridCol w:w="'.$colWidth.'"/>';
        }
        $gridXml .= '</w:tblGrid>';

        $xml = '
        <w:tbl>
            <w:tblPr>
                <w:tblW w:w="'.$totalWidth.'" w:type="dxa"/>
                <w:jc w:val="center"/>
                <w:tblCellMar>
                    <w:top w:w="80" w:type="dxa"/>
                    <w:left w:w="120" w:type="dxa"/>
                    <w:bottom w:w="80" w:type="dxa"/>
                    <w:right w:w="120" w:type="dxa"/>
                </w:tblCellMar>
                <w:tblBorders>
                    <w:top w:val="single" w:sz="8" w:space="0" w:color="334155"/>
                    <w:left w:val="single" w:sz="8" w:space="0" w:color="334155"/>
                    <w:bottom w:val="single" w:sz="8" w:space="0" w:color="334155"/>
                    <w:right w:val="single" w:sz="8" w:space="0" w:color="334155"/>
                    <w:insideH w:val="single" w:sz="6" w:space="0" w:color="94A3B8"/>
                    <w:insideV w:val="single" w:sz="6" w:space="0" w:color="94A3B8"/>
                </w:tblBorders>
            </w:tblPr>
            '.$gridXml;

        foreach ($rows as $row) {
            $xml .= '<w:tr>';
            foreach ($row['cells'] as $cellHtml) {
                $isCellBold = $row['isHeader'] || str_contains($cellHtml, '<strong>') || str_contains($cellHtml, '<b>');
                $isCellHeader = $row['isHeader'];
                $plainText = strip_tags(str_replace(['<br>', '<br/>', '<br />'], "\n", $cellHtml));
                $plainText = html_entity_decode($plainText, ENT_QUOTES | ENT_XML1, 'UTF-8');

                $xml .= '<w:tc>';
                $xml .= '<w:tcPr>';
                $xml .= '<w:tcW w:w="'.$colWidth.'" w:type="dxa"/>';
                if ($isCellHeader) {
                    $xml .= '<w:shd w:val="clear" w:color="auto" w:fill="F1F5F9"/>';
                }
                $xml .= '</w:tcPr>';

                $lines = explode("\n", $plainText);
                $hasText = false;
                foreach ($lines as $line) {
                    $line = trim($line);
                    if ($line !== '') {
                        $hasText = true;
                        $xml .= '<w:p><w:pPr><w:spacing w:before="20" w:after="20"/></w:pPr><w:r>';
                        if ($isCellBold) {
                            $xml .= '<w:rPr><w:b/></w:rPr>';
                        }
                        $xml .= '<w:t>'.htmlspecialchars($line, ENT_XML1).'</w:t></w:r></w:p>';
                    }
                }
                if (! $hasText) {
                    $xml .= '<w:p><w:r><w:t></w:t></w:r></w:p>';
                }
                $xml .= '</w:tc>';
            }
            $xml .= '</w:tr>';
        }

        $xml .= '</w:tbl>';

        return $xml;
    }

    /**
     * Tanda Tangan Resmi Pengurus PWI Banyuasin
     */
    protected function buildTandaTanganXml(Letter $letter): string
    {
        $ketua = htmlspecialchars($letter->penandatangan_nama ?? 'Wardoyo, S.I.Kom', ENT_XML1);
        $sekretaris = htmlspecialchars($letter->penandatangan_sekretaris ?? 'Deni Arianto', ENT_XML1);
        $isKhusus = ($letter->jenis_surat === 'SURAT KHUSUS' || empty($letter->penandatangan_sekretaris));

        $headerXml = '
        <w:p>
            <w:pPr><w:jc w:val="center"/><w:spacing w:before="360" w:after="40"/></w:pPr>
            <w:r><w:t>Hormat kami,</w:t></w:r>
        </w:p>
        <w:p>
            <w:pPr><w:jc w:val="center"/><w:spacing w:before="0" w:after="160"/></w:pPr>
            <w:r><w:b/><w:t>Pengurus PWI Banyuasin</w:t></w:r>
        </w:p>';

        if ($isKhusus) {
            return $headerXml.'
            <w:p>
                <w:pPr><w:jc w:val="center"/><w:spacing w:before="600" w:after="40"/></w:pPr>
                <w:r><w:b/><w:u w:val="single"/><w:t>'.$ketua.'</w:t></w:r>
            </w:p>
            <w:p>
                <w:pPr><w:jc w:val="center"/><w:spacing w:before="0" w:after="120"/></w:pPr>
                <w:r><w:t>Ketua</w:t></w:r>
            </w:p>';
        }

        return $headerXml.'
        <w:tbl>
            <w:tblPr>
                <w:tblW w:w="8000" w:type="dxa"/>
                <w:jc w:val="center"/>
                <w:tblBorders>
                    <w:top w:val="none"/><w:left w:val="none"/><w:bottom w:val="none"/><w:right w:val="none"/><w:insideH w:val="none"/><w:insideV w:val="none"/>
                </w:tblBorders>
            </w:tblPr>
            <w:tblGrid>
                <w:gridCol w:w="4000"/>
                <w:gridCol w:w="4000"/>
            </w:tblGrid>
            <w:tr>
                <w:tc>
                    <w:tcPr><w:tcW w:w="4000" w:type="dxa"/></w:tcPr>
                    <w:p>
                        <w:pPr><w:jc w:val="center"/><w:spacing w:before="600" w:after="40"/></w:pPr>
                        <w:r><w:b/><w:u w:val="single"/><w:t>'.$ketua.'</w:t></w:r>
                    </w:p>
                    <w:p>
                        <w:pPr><w:jc w:val="center"/><w:spacing w:before="0" w:after="120"/></w:pPr>
                        <w:r><w:t>Ketua</w:t></w:r>
                    </w:p>
                </w:tc>
                <w:tc>
                    <w:tcPr><w:tcW w:w="4000" w:type="dxa"/></w:tcPr>
                    <w:p>
                        <w:pPr><w:jc w:val="center"/><w:spacing w:before="600" w:after="40"/></w:pPr>
                        <w:r><w:b/><w:u w:val="single"/><w:t>'.$sekretaris.'</w:t></w:r>
                    </w:p>
                    <w:p>
                        <w:pPr><w:jc w:val="center"/><w:spacing w:before="0" w:after="120"/></w:pPr>
                        <w:r><w:t>Sekretaris</w:t></w:r>
                    </w:p>
                </w:tc>
            </w:tr>
        </w:tbl>';
    }

    /**
     * Tembusan Surat Resmi
     */
    protected function buildTembusanXml(Letter $letter): string
    {
        $tembusan = $letter->tembusan !== null ? trim($letter->tembusan) : '1. Arsip.';
        if (empty($tembusan) || $tembusan === '-') {
            return '';
        }

        $lines = preg_split('/\r\n|\r|\n/', $tembusan);
        $xml = '
        <w:p>
            <w:pPr>
                <w:spacing w:before="240" w:after="40"/>
            </w:pPr>
            <w:r>
                <w:rPr><w:b/><w:sz w:val="20"/></w:rPr>
                <w:t>Tembusan :</w:t>
            </w:r>
        </w:p>';

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line !== '') {
                $xml .= '
                <w:p>
                    <w:pPr>
                        <w:spacing w:before="20" w:after="20"/>
                    </w:pPr>
                    <w:r>
                        <w:rPr><w:sz w:val="20"/></w:rPr>
                        <w:t>'.htmlspecialchars($line, ENT_XML1).'</w:t>
                    </w:r>
                </w:p>';
            }
        }

        return $xml;
    }

    /**
     * Digital Verification Footer with Link & UUID
     */
    protected function buildKeabsahanFooterXml(Letter $letter): string
    {
        $verifyUrl = $letter->verification_url ?? route('letter.verify', $letter->uuid ?? $letter->id);
        $uuid = $letter->uuid ?? (string) Str::uuid();

        return '
        <w:p>
            <w:pPr>
                <w:spacing w:before="400" w:after="0"/>
                <w:pBdr>
                    <w:top w:val="single" w:sz="6" w:space="4" w:color="CCCCCC"/>
                </w:pBdr>
            </w:pPr>
            <w:r>
                <w:rPr><w:sz w:val="15"/><w:color w:val="666666"/><w:i/></w:rPr>
                <w:t>Dokumen digital resmi PWI Banyuasin. Keabsahan dapat diverifikasi melalui URL: '.htmlspecialchars($verifyUrl, ENT_XML1).' [UUID: '.$uuid.']</w:t>
            </w:r>
        </w:p>';
    }
}
