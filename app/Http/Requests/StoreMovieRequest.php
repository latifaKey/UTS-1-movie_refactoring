<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMovieRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    // Aturan validasi input form saat menyimpan data Movie.
    public function rules()
    {
        return [
            'id' => ['required', 'string', 'max:255', Rule::unique('movies', 'id')],
            'judul' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'sinopsis' => ['required', 'string'],
            'tahun' => ['required', 'integer'],
            'pemain' => ['required', 'string'],
            'foto_sampul' => $this->imageRules(),
        ];
    }

    // Aturan validasi khusus untuk gambar/foto sampul.
    protected function imageRules()
    {
        return ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'];
    }

    // Fungsi baru: menyiapkan dan membersihkan input sebelum divalidasi
    protected function prepareForValidation()
    {
        $this->merge([
            'judul' => trim($this->judul),
            'pemain' => trim($this->pemain),
        ]);
    }
}
