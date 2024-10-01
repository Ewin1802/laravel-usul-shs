<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StoreUsulshsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'Kode' => 'required',
            'Uraian' => 'required|exists:kelompoks,Uraian',
            'Spek' => 'required',
            'Satuan' => 'required|exists:satuans,satuan',
            'Harga' => 'required',
            'akun_belanja' => 'required|exists:belanjas,Belanja',
            'rekening_1' => 'required|exists:belanjas,Rekening',
            'rekening_2' => 'nullable',
            'rekening_3' => 'nullable',
            'rekening_4' => 'nullable',
            'rekening_5' => 'nullable',
            'rekening_6' => 'nullable',
            'rekening_7' => 'nullable',
            'rekening_8' => 'nullable',
            'rekening_9' => 'nullable',
            'rekening_10' => 'nullable',
            'Kelompok' => '1',
            'nilai_tkdn' => 'required|numeric|min:41',
            'Document' => 'required|exists:documents,judul',
            'user' => 'nullable',
            'skpd' => 'nullable',
        ]);
    }


}