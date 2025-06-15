<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class CakupanData extends Model
{
    use HasFactory;
    protected $table = 'cakupan_data';
    protected $fillable = ['nama'];
} 