<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\TenantScope;
class TicketHistory extends Model
{
    protected $table = 'ticket_history';
    protected $primaryKey = 'history_id';

    protected static function booted(): void{
        static::addGlobalScope(new TenantScope);
    }

    protected $fillable = [
        'tenant_id',
        'ticket_id',
        'changed_by_user_id',
        'from_status',
        'to_status',
        'ticket_comment',
        'resolution_note',
    ];

    public function ticket(){
        return $this->belongsTo(Ticket::class, 'ticket_id', 'ticket_id');
    }

    public function changedBy(){
        return $this->belongsTo(User::class, 'changed_by_user_id', 'user_id');
    }

}
