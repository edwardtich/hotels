<?php

namespace frontend\helpers\sitemap;

class Sitemap
{
    /**
     * @param iterable|MapItem[] $items
     * @return mixed
     */
    public function generateMap($items)
    {
        $writer = new \XMLWriter();
        $writer->openMemory();
        $writer->startDocument('1.0', 'UTF-8');
        $writer->setIndent(true);
        $writer->startElement('urlset');
        $writer->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        foreach ($items as $item) {
            $writer->startElement('url');

            $writer->writeElement('loc', $item->location);
            if ($item->lastModified !== null) {
                $writer->writeElement('lastmod', date('c', $item->lastModified));
            }
            if ($item->changeFrequency !== null) {
                $writer->writeElement('changefreq', $item->changeFrequency);
            }
            if ($item->priority !== null) {
                $writer->writeElement('priority', number_format($item->priority, 1, '.', ','));
            }
            $writer->endElement();
        }

        $writer->endElement();
        $writer->endDocument();

        return $writer->flush();
    }
}