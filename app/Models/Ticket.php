<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\TenantScope;

class Ticket extends Model
{
    protected static function booted(): void{
        static::addGlobalScope(new TenantScope);
    }
    
    /** @use HasFactory<\Database\Factories\TicketFactory> */
    use HasFactory;
    protected $primaryKey = 'ticket_id';
    protected $fillable = [
        'tenant_id',
        'user_id',
        'assigned_user_id',
        'ticket_title',
        'ticket_description',
        'ticket_category',
        'ticket_priority',
        'ticket_status',
    ];
    public const categories = ['Billing', 'Query', 'Technical'];
    public const priorities = ['low', 'medium', 'high', 'urgent'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function tenant(){
        return $this->belongsTo(Tenant::class, 'tenant_id', 'tenant_id');
    }

    public function assignee(){
        return $this->belongsTo(User::class, 'assigned_user_id', 'user_id');
    }

    
}
