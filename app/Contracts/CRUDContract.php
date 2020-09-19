<?php

namespace App\Contracts;
use Illuminate\Http\Request;

interface CRUDContract
{
    public function add();
    public function add_action(Request $req);
    public function update(Request $req,$id);
    public function update_action(Request $req,$id);
    public function delete($id);
}
