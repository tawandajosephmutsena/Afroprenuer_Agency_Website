<?php

namespace App\Traits;

trait HasSeo
{
    public function getSeoTitle(): string
    {
        return $this->seo_title ?? $this->title;
    }

    public function getSeoDescription(): string
    {
        return $this->seo_description ??
            ($this->excerpt ?? substr(strip_tags($this->content), 0, 160));
    }

    public function getSeoKeywords(): array
    {
        return $this->seo_keywords ?? [];
    }

    public function toSeoArray(): array
    {
        return [
            "title" => $this->getSeoTitle(),
            "description" => $this->getSeoDescription(),
            "keywords" => $this->getSeoKeywords(),
        ];
    }
}
