Ciao, vorrei iscrivermi ad Easy LANGA con profilazione <p><strong>{{$user->dipartimento}}</strong></p>Attiveresti la mia utenza?
<br>
Nome: {{$user->name}}<br>
Email: {{$emailutente}}<br>
<br><br><br>
Clicca <a href="{{url('/admin/utenti/attiva/id') . "/" . $user->id . '/password/' . urlencode($pswd) . "/email/" . urlencode($emailutente) }}" target="new">QUI</a> per confermare la password scelta dall'utente.
<br><br><br>
Grazie.
<br><br>
p.s. ricorda che per poter confermare un utenza hai bisogno di essere loggato come Admin.