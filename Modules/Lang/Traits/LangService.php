<?php

namespace Module\Lang\Traits;

use Exception;

trait LangService
{
    /**
     * Set new language for $translatable
     *
     * @param string $key
     * @param string $locale
     * @param string $value
     * @return $this
     */
    public function setTranslation(string $key, string $locale, string $value)
    {
        $translations = $this->getTranslations($key);

        $translations[$locale] = $value;
        $this->attributes[$key] = $this->asJson($translations);

        return $this;
    }

    /**
     * Get value language
     *
     * @param string $key
     * @param string $locale
     * @return mixed|string
     * @throws Exception
     */
    public function getTranslation(string $key, string $locale)
    {
        $locale = $this->normalizeLocale($key, $locale);

        $translations = $this->getTranslations($key);
        return $translations[$locale] ?? '';
    }

    /**
     * @param string $key
     * @return array
     */
    public function getTranslations(string $key): array
    {
        return array_filter(json_decode($this->getAttributes()[$key] ?? '' ?: '{}', true) ?: [], function ($value) {
            return $value !== null && $value !== '';
        });
    }

    /**
     * @throws Exception
     */
    public function normalizeLocale(string $key, string $locale): ?string
    {
        if (in_array($locale, $this->getTranslatedLocales($key))) {
            return $locale;
        }
        throw new Exception("$locale not found");
    }

    public function getTranslatedLocales(string $key): array
    {
        return array_keys($this->getTranslations($key));
    }
}
