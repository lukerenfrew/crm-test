<?php

namespace App\Http\Requests;

trait UploadsLogo
{
    public function validatedWithLogo(): array
    {
        return array_merge($this->validated(), ['logo' => $this->uploadLogo()]);
    }

    private function uploadLogo(): ?string
    {
        if ($this->hasFile('logo') === false) {
            return null;
        }

        return $this->file('logo')->store('', ['disk' => 'logos']);
    }
}
