<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WithRelationshipsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'with' => 'string|nullable',
        ];
    }

    /**
     * Validates the request and return an error of the requested relationships.
     * @param string[] $validRelationships
     */
    public function getRequestedRelationships($validRelationships) {
        $validated = $this->validated();

        $withRelations = [];

        if (isset($validated['with'])) {
            $withParams = explode(',', $validated['with']);
            foreach ($withParams as $param) {
                if (in_array($param, $validRelationships)){
                    array_push($withRelations, $param);
                }
            }
        }

        return $withRelations;
    }
}
