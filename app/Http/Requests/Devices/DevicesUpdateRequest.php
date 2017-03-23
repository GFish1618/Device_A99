<?php

namespace App\Http\Requests\Devices;

use App\Http\Requests\Request;

class DevicesUpdateRequest extends Request
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
            'user_name' => 'required',
            'device_name' => 'required',//'unique:devices',
            'mac_adress' => 'min:17|max:17|regex:#([a-fA-F0-9]{2}:){5}[a-f0-9]{2}#',
            'ownership' => 'required',
            'unit_sn' => 'regex:#[^a-z]#',
            'keyboard_sn' => 'regex:#[^a-z]#',
            'mouse_sn' => 'regex:#[^a-z]#',
            'external_monitor' => '',
            'external_mon_cable' => '',
            'installed_memory' => 'integer',
            'core_speed' => 'integer',
            'purchased_date' => 'date',
            'current_location' => '',
            'password' => '',
            'os_version' => '',
            'department' => '',
            'remarks' => ''
        ];
    }
}
