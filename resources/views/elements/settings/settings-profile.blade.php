@if(!Auth::user()->email_verified_at) @include('elements.resend-verification-email-box') @endif

@if(getSetting('ai.open_ai_enabled'))
    @include('elements.suggest-description')
@endif

<form method="POST" action="{{route('my.settings.profile.save',['type'=>'profile'])}}">
    @csrf
    @include('elements.dropzone-dummy-element')
    <div class="mb-4 post-setting-profile">
        <div class="post-avtar-setting">
            <div class="card profile-cover-bg">
                <img class="card-img-top centered-and-cropped" src="{{Auth::user()->cover}}">
                <div class="card-img-overlay d-flex justify-content-center align-items-center cross-button-setting">
                    <div class="actions-holder d-none">

                        <div class="d-flex corss-button-profile">
                        <span class="span-profile-icon-cover h-pill h-pill-accent pointer-cursor mr-1 upload-button test" data-toggle="tooltip" data-placement="top" title="{{__('Upload cover image')}}">
                             @include('elements.icon',['icon'=>'image','variant'=>'medium'])
                        </span>
                            <span class="span-profile-icon-cover h-pill h-pill-accent pointer-cursor" onclick="ProfileSettings.removeUserAsset('cover')" data-toggle="tooltip" data-placement="top" title="{{__('Remove cover image')}}">
                            @include('elements.icon',['icon'=>'close','variant'=>'medium'])
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container post-setting-image">
            <div class="card avatar-holder">
                <img class="card-img-top" src="{{Auth::user()->avatar}}">
                <div class="card-img-overlay d-flex justify-content-center align-items-center cross-button-setting">
                    <div class="actions-holder d-none">
                        <div class="d-flex corss-button-profile-avtar">
                        <span class="span-profile-icon-avtar h-pill h-pill-accent pointer-cursor mr-1 upload-button" data-toggle="tooltip" data-placement="top" title="{{__('Upload avatar')}}">
                            @include('elements.icon',['icon'=>'image','variant'=>'medium'])
                        </span>
                            <span class="span-profile-icon-avtar h-pill h-pill-accent pointer-cursor" onclick="ProfileSettings.removeUserAsset('avatar')" data-toggle="tooltip" data-placement="top" title="{{__('Remove avatar')}}">
                             @include('elements.icon',['icon'=>'close','variant'=>'medium'])
                        </span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(session('success'))
        <div class="alert alert-success text-white font-weight-bold mt-2" role="alert">
            {{session('success')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="form-group">
        <label for="username">{{__('Username')}}</label>
        <input class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" id="username" name="username" aria-describedby="emailHelp" value="{{Auth::user()->username}}">
        @if($errors->has('username'))
            <span class="invalid-feedback" role="alert">
                <strong>{{$errors->first('username')}}</strong>
            </span>
        @endif

        {{--   TODO: Maybe enable this when we'll add mentions & tags    --}}
        {{--        <div class="input-group">--}}
        {{--            <div class="input-group-prepend">--}}
        {{--                <span class="input-group-text" id="username-label">@</span>--}}
        {{--            </div>--}}
        {{--            <input class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" id="username" name="username" aria-describedby="emailHelp" value="{{Auth::user()->username}}">--}}
        {{--            @if($errors->has('username'))--}}
        {{--                <span class="invalid-feedback" role="alert">--}}
        {{--                <strong>{{$errors->first('username')}}</strong>--}}
        {{--            </span>--}}
        {{--            @endif--}}
        {{--        </div>--}}

    </div>
    <div class="form-group">
        <label for="name">{{__('Full name')}}</label>
        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" name="name" aria-describedby="emailHelp" value="{{Auth::user()->name}}">
        @if($errors->has('name'))
            <span class="invalid-feedback" role="alert">
                <strong>{{$errors->first('name')}}</strong>
            </span>
        @endif
    </div>
    <div class="form-group">
        <div class="d-flex justify-content-between">
            <label for="bio">
                {{__('Bio')}}
            </label>
            <div>
                @if(getSetting('ai.open_ai_enabled'))
                    <a href="javascript:void(0)" onclick="{{"AiSuggestions.suggestDescriptionDialog();"}}" data-toggle="tooltip" data-placement="left" title="{{__('Use AI to generate your description.')}}">{{trans_choice("Suggestion",2)}}</a>
                @endif
            </div>
        </div>
        <textarea class="form-control {{ $errors->has('bio') ? 'is-invalid' : '' }}" id="bio" name="bio" rows="3" spellcheck="false">{{Auth::user()->bio}}</textarea>
        @if($errors->has('bio'))
            <span class="invalid-feedback" role="alert">
                <strong>{{$errors->first('bio')}}</strong>
            </span>
        @endif
    </div>

    <div class="form-group">

        <div class="d-flex justify-content-between">
            <label for="interest">
                {{__('Interest')}}
            </label>            
        </div>
        @php
        $userInterests = Auth::user()->interests->pluck('id')->toArray();
        @endphp        
       <div class="profile-checkboxes-flex">      
        @foreach ($interests as $interest)
        <div class='interset-checkboxes-wrapper'>
            <label class='inteest-all-lables'>              
                {{$interest->name}}
            </label>
            <input class='interset-checbokes' type="checkbox" name="interests[]" value="{{ $interest->id }}" {{ in_array($interest->id, $userInterests) ? 'checked' : '' }}>
            <br>
        </div>
        @endforeach
        </div>
     

        @if($errors->has('interests'))
            <span class="invalid-feedback" role="alert">
                <strong>{{$errors->first('interests')}}</strong>
            </span>
        @endif
    </div>
    <div class="form-group">
        <label for="birthdate">{{__('Birthdate')}}</label>
        <input type="date" class="form-control {{ $errors->has('location') ? 'is-invalid' : '' }}" id="birthdate" name="birthdate" aria-describedby="emailHelp"  value="{{Auth::user()->birthdate}}" max="{{$minBirthDate}}">
        @if($errors->has('birthdate'))
            <span class="invalid-feedback" role="alert">
                <strong>{{$errors->first('birthdate')}}</strong>
            </span>
        @endif
    </div>

    <div class="d-flex flex-row">
        <div class="{{getSetting('profiles.allow_gender_pronouns') ? 'w-50' : 'w-100'}} pr-2">
            <div class="form-group">
                <label for="gender">{{__('Gender')}}</label>
                <select class="form-control" id="gender" name="gender" >
                    <option value=""></option>
                    @foreach($genders as $gender)
                        <option value="{{$gender->id}}" {{Auth::user()->gender_id == $gender->id ? 'selected' : ''}}>{{__($gender->gender_name)}}</option>
                    @endforeach
                </select>
                @if($errors->has('gender'))
                    <span class="invalid-feedback" role="alert">
                <strong>{{$errors->first('gender')}}</strong>
            </span>
                @endif
            </div>
        </div>

        @if(getSetting('profiles.allow_gender_pronouns'))
            <div class="w-50 pl-2">
                <div class="form-group">
                    <label for="pronoun">{{__('Gender pronoun')}}</label>
                    <input class="form-control {{ $errors->has('location') ? 'is-invalid' : '' }}" id="pronoun" name="pronoun" aria-describedby="emailHelp"  value="{{Auth::user()->gender_pronoun}}">
                    @if($errors->has('pronoun'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{$errors->first('pronoun')}}</strong>
                    </span>
                    @endif
                </div>
            </div>
        @endif

    </div>

    <div class="form-group">
        <label for="location">{{__('Location')}}</label>
        <input class="form-control {{ $errors->has('location') ? 'is-invalid' : '' }}" id="location" name="location" aria-describedby="emailHelp"  value="{{Auth::user()->location}}">
        @if($errors->has('location'))
            <span class="invalid-feedback" role="alert">
                <strong>{{$errors->first('location')}}</strong>
            </span>
        @endif
    </div>

    <div class="form-group">
        <label for="website" value="{{Auth::user()->website}}">{{__('Website URL')}}</label>
        <input type="url" class="form-control {{ $errors->has('website') ? 'is-invalid' : '' }}" id="website" name="website" aria-describedby="emailHelp" value="{{Auth::user()->website}}">
        @if($errors->has('website'))
            <span class="invalid-feedback" role="alert">
                <strong>{{$errors->first('website')}}</strong>
            </span>
        @endif
    </div>
    <button class="btn btn-primary btn-block rounded mr-0" type="submit">{{__('Save')}}</button>
</form>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    var checkboxesWrapper = document.querySelectorAll('.interset-checkboxes-wrapper');

    checkboxesWrapper.forEach(function (wrapper) {
        var checkbox = wrapper.querySelector('.interset-checbokes');
        var label = wrapper.querySelector('.inteest-all-lables');

        wrapper.addEventListener('click', function (event) {
            // Check if the click occurred on the checkbox
            if (event.target === checkbox) {
                return;
            }

            checkbox.checked = !checkbox.checked;
            toggleCheckboxStyles(checkbox, label);
        });

        // Set initial styles based on checkbox state
        toggleCheckboxStyles(checkbox, label);
    });

    function toggleCheckboxStyles(checkbox, label) {
        var isChecked = checkbox.checked;

        if (isChecked) {
            checkbox.style.backgroundColor = '#ff0000';
            label.style.color = '#fff';
            // Add any other styles you want for the label and checkbox when checked
        } else {
            checkbox.style.backgroundColor = '';
            label.style.color = '';
            // Reset styles when unchecked
        }
    }
});

    </script>


