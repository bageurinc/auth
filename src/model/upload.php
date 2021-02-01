<?php

namespace Bageur\Auth\Model;

use Illuminate\Database\Eloquent\Model;

class upload extends Model
{
    protected $table   = 'bgr_upload';
    protected $hidden = [
        'file', 'folder','type'
    ];
    protected $appends = ['info'];
    public function getInfoAttribute()
    {
        $data = [
            'base64' => url('storage/'.$this->folder.'/'.$this->file), 
            'folder' => $this->folder, 
            'name' => $this->file, 
            'type' => $this->type, 
        ];
        return $data;
    }
}
