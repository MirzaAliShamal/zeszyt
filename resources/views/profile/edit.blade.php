@extends('layouts.app')
@section('page_title', 'My Profile')

@section('content')

 <section class="section">
  <div class="section-body">
   <div class="row mt-sm-4">
    <div class="col-12 col-md-12 col-lg-12">
     <div class="card">
      <div class="padding-20">
       <ul class="nav nav-tabs" id="myTab2" role="tablist">
        <li class="nav-item">
         <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#about" role="tab"
          aria-selected="true">Profil</a>
        </li>
        <li class="nav-item">
         <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#settings" role="tab"
          aria-selected="false">Ustawienia</a>
        </li>
        <li class="nav-item">
         <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#password-tab" role="tab"
          aria-selected="false">Hasło</a>
        </li>
        <li class="nav-item">
         <a class="nav-link" id="profile-tab4" data-toggle="tab" href="#contact-form-tab" role="tab"
          aria-selected="false">Formularz kontaktowy</a>
        </li>
       </ul>
       <div class="tab-content tab-bordered" id="myTab3Content">
        <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="home-tab2">
         <div class="row">
          <div class="col-md-3 col-6 b-r">
           <strong>Company Name</strong>
           <br>
           <p class="text-muted">{{ $my_profile->company_name }}</p>
          </div>
          <div class="col-md-3 col-6 b-r">
           <strong>Form of organization</strong>
           <br>
           <p class="text-muted">{{ $my_profile->form_of_organization }}</p>
          </div>
          <div class="col-md-3 col-6 b-r">
           <strong>Form of income taxes</strong>
           <br>
           <p class="text-muted">{{ $my_profile->form_of_income_taxes }}</p>
          </div>
         </div>
        </div>
        <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="profile-tab2">
         <form method="post" class="needs-validation" action="{{ route('profile.update') }}">
          @csrf
          <div class="card-header">
           <h4>Edycja profilu</h4>
          </div>
          <div class="card-body">
           <div class="row">
            <div class="form-group col-md-6 col-12">
             <label>Nazwa</label>
             <input type="text" class="form-control" name="company_name" required>
            </div>
            <div class="form-group col-md-6 col-12">
             <label>Forma działalności</label>
             <input type="text" class="form-control" name="form_of_organization"
              value="{{ $my_profile->form_of_organization }}" required>
            </div>
           </div>
           <div class="row">
            <div class="form-group col-md-6 col-12">
             <label>Forma opodatkowania</label>
             <input type="text" class="form-control" name="form_of_income_taxes"
              value="{{ $my_profile->form_of_income_taxes }}" required>
            </div>
            <div class="form-group col-md-6 col-12">
             <label>Skontaktuj się z nami</label>
             <input type="text" class="form-control" name="contact_with_us" value="{{ $my_profile->contact_with_us }}"
              required>
            </div>
           </div>
          </div>
          <div class="card-footer text-right">
           <button class="btn btn-primary">Zapisz zmiany</button>
          </div>
         </form>
        </div>
        <div class="tab-pane fade" id="password-tab" role="tabpanel" aria-labelledby="profile-tab2">
         <form method="post" action="{{ route('profile.update-password') }}">
          @csrf
          <div class="card-header">
           <h4>Zaktualizuj hasło</h4>
          </div>
          <div class="card-body">
           <div class="row">
            <div class="form-group col-md-6 col-12">
             <label>Hasło</label>
             <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group col-md-6 col-12">
             <label>potwierdź hasło</label>
             <input type="password" class="form-control" id="confirm-password" required>
             <span class="message"></span>
            </div>
           </div>
          </div>
          <div class="card-footer text-right">
           <button type="submit" id="update-password-submit" class="btn btn-primary">Zaktualizuj
            hasło</button>
          </div>
         </form>
        </div>
        <div class="tab-pane fade" id="contact-form-tab" role="tabpanel" aria-labelledby="profile-tab4">
         <form method="post" action="{{ route('profile.update-contact') }}">
          @csrf
          <div class="card-header">
           <h4>Formularz kontaktowy</h4>
          </div>
          <div class="card-body">
           <div class="row">
            <div class="form-group col-md-4 col-12">
             <label>Imię i nazwisko</label>
             <input type="text" class="form-control" name="name" required value="{{ $contact->name }}">
            </div>
            <div class="form-group col-md-4 col-12">
             <label>Numer telefonu</label>
             <input type="text" class="form-control" name="phone_number" required
              value="{{ $contact->phone_number }}">
            </div>
            <div class="form-group col-md-4
              col-12">
             <label>E-mail</label>
             <input type="email" class="form-control" name="email" required value="{{ $contact->email }}">
            </div>
            <div class="form-group col-md-12 col-12">
             <label>Kategoria</label>
             <select name="category" class="form-control" required>
              <option value="">Wybierz kategorię</option>
              @foreach ($categories as $key => $list)
               @if ($key == $contact->category)
                <option value="{{ htmlspecialchars($key) }}" selected>{{ htmlspecialchars($list) }}
                @else
                <option value="{{ htmlspecialchars($key) }}">{{ htmlspecialchars($list) }}
               @endif
               </option>
              @endforeach
             </select>
            </div>
            <div class="form-group col-md-12 col-12">
             <label>Tytuł wiadomości</label>
             <input type="text" class="form-control" name="title" required value="{{ $contact->title }}">
            </div>
            <div class="form-group col-md-12 col-12">
             <label>Treść wiadomości</label>
             <textarea name="content" cols="30" rows="10" class="form-control" required>{{ $contact->content }}</textarea>
            </div>
           </div>
          </div>
          <div class="card-footer text-right">
           <button type="submit" id="update-password-submit" class="btn btn-primary">Składać</button>
          </div>
         </form>
        </div>
       </div>
      </div>
     </div>
    </div>
   </div>
  </div>
 </section>

@section('script')
 <script type="text/javascript">
  $(document).ready(function() {
   $('#password, #confirm-password').on('keyup', function(e) {
    let password = $('#password').val();
    let confirmPassword = $('#confirm-password').val();

    if (password == confirmPassword) {
     $('#update-password-submit').removeAttr('disabled');
     $('.message').text('');
    } else {
     e.preventDefault()
     $('#update-password-submit').attr('disabled', true);
     $('.message').text('Passwords do not match').css('color', 'red');
    }
   });
  });
 </script>
@endsection
@endsection
