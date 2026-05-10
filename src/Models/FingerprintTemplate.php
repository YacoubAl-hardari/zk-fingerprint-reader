<?php

namespace Yacoubalhaidari\ZKFinger\Models;

use Illuminate\Database\Eloquent\Model;

class FingerprintTemplate extends Model
{
    protected $table = 'fingerprint_templates';
    protected $fillable = ['user_id', 'template_b64', 'template_type', 'engine_version', 'quality_score'];
    protected $hidden = ['template_b64'];

    public function getTemplateSize(): int
    {
        return strlen(base64_decode($this->template_b64));
    }
}
