$user = \App\Models\User::create(['name'=>'Admin User','email'=>'admin@example.com','password'=>bcrypt('admin123')]);
echo "User id: ".$user->id;
