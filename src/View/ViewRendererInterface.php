<?php
declare(strict_types=1);
namespace ErickFinancas\View;

interface ViewRendererInterface
{
    public function render(string $template, array $context = []);
}