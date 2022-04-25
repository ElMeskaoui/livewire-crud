<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use App\Models\User;

class Users extends Component
{
    public $users, $name, $email, $user_id,$posts;
    public $updateMode = false,$showpost=false;

    public function render()
    {
        $this->users = User::all();
        return view('livewire.users');
    }

    private function resetInputFields(){
        $this->name = '';
        $this->email = '';
    }

    public function store()
    {
        $validatedDate = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        User::create($validatedDate);

        session()->flash('message', 'Users Created Successfully.');

        $this->resetInputFields();

    }

    public function edit($id)
    {
        $this->updateMode = true;
        $user = User::where('id',$id)->first();
        $this->user_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;

    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();


    }

    public function update()
    {
        $validatedDate = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        if ($this->user_id) {
            $user = User::find($this->user_id);
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
            ]);
            $this->updateMode = false;
            session()->flash('message', 'Users Updated Successfully.');
            $this->resetInputFields();

        }
    }

    public function delete($id)
    {
        if($id){
            User::where('id',$id)->delete();
            session()->flash('message', 'Users Deleted Successfully.');
        }
    }

    public function showPost($id)
    {
        $this->posts=Post::where('user_id',$id)->get();
        $this->posts=[
            'id'=>222,
            'titel'=>'qqqqqqqq',
            'description'=>'sda;kfjnsdkjfs jkhaskkjfhsigfbas skdsjfgaskjfgaskf '
        ];
        $this->showpost=true;
        return view('livewire.postss');


    }


}
