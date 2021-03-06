<?php

namespace App\Services\CommonMark;

use League\CommonMark\Block\Element\FencedCode;
use League\CommonMark\Block\Element\Heading;
use League\CommonMark\Block\Element\IndentedCode;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Ext\Autolink\AutolinkExtension;
use League\CommonMark\Ext\SmartPunct\SmartPunctExtension;
use League\CommonMark\Ext\Strikethrough\StrikethroughExtension;
use League\CommonMark\Inline\Element\Image;
use Spatie\CommonMarkHighlighter\FencedCodeRenderer;
use Spatie\CommonMarkHighlighter\IndentedCodeRenderer;
use League\CommonMark\Ext\Table\TableExtension;

class CommonMark
{
    public static function convertToHtml(string $markdown, bool $isRenderingExcerpt = false): string
    {
        $environment = Environment::createCommonMarkEnvironment()
            ->addBlockRenderer(FencedCode::class, new FencedCodeRenderer())
            ->addBlockRenderer(IndentedCode::class, new IndentedCodeRenderer())
            ->addBlockRenderer(Heading::class, new HeadingRenderer($isRenderingExcerpt))
            ->addInlineRenderer(Image::class, new FigureImageRenderer())
            ->addExtension(new AutolinkExtension())
            ->addExtension(new SmartPunctExtension())
            ->addExtension(new StrikethroughExtension())
            ->addExtension(new TableExtension());

        $commonMarkConverter = new CommonMarkConverter([], $environment);

        return $commonMarkConverter->convertToHtml($markdown);
    }
}
