<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\ResourceCollection;

class RenterInfoCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
     
        return $this->collection->map(function($user){
            return [
                'firstname' => $user->renterinfo->Firstname,
                'lastname' => $user->renterinfo->Lastname,
                'emovedate' => $user->renterinfo->Emove_date,
                'probability' => $user->renterinfo->probability,
                'lmovedate' => $user->renterinfo->Lmove_date,
                'remainderdate' => $user->renterinfo->Reminder_date,
                'status' => $user->Status,
                'admin'=> $user->renterinfo->admindetails->admin_name
            ];
        })->first();
    }
}
