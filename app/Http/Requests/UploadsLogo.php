<?php

namespace App\Http\Requests;

trait UploadsLogo
{
    public function validatedWithLogo(): array
    {
        $logo = $this->uploadLogo();
        $mergedInput = array_merge($this->validated(), ['logo' => $logo]);

        return array_filter($mergedInput);
    }

    private function uploadLogo(): ?string
    {
        if ($this->hasFile('logo') === false) {
            return null;
        }

        return $this->file('logo')->store('', ['disk' => 'logos']);
    }
}
