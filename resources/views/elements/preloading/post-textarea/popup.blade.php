<div class="interest-on-signup">
    <!-- Add style="display:none;" to hide the dialog initially -->
    <div id="dialog-container" class="dialog-container" style="display:block;">
        <div class="dialog_box_outer_section">
        <div class="dialog-box">
            <span class="close-btn" onclick="closeDialog()">Skip</span>          
            <form method="POST" action="{{route('my.settings.profile.saveInterest')}}">              
                @csrf
                <div class="checkbox-container justify-content-between">
                  <h3 class="interest_list">Please Select Your Interests</h3>
                    @php
                    $userInterests = Auth::user()->interests->pluck('id')->toArray();
                    @endphp
                   
                   <div class="profile-checkboxes-flex popup_interest">      

                    @foreach ($interests as $interest)
                    <div class='interset-checkboxes-wrapper'>
                        <label class='inteest-all-lables'>              
                            
                            {{ $interest->name }}
                        </label>
                        <input class='interset-checbokes' type="checkbox" name="interests[]" value="{{ $interest->id }}" {{ in_array($interest->id, $userInterests) ? 'checked' : '' }}>
                        <br>
                        </div>
                    @endforeach
                    <!-- Add other checkbox elements as needed -->

                </div>
                </div>

                <input type="submit" value="Submit">
            </form>
        </div>
    </div>    
    </div>
</div>
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
            label.style.color = '#000000';
            // Add any other styles you want for the label and checkbox when checked
        } else {
            checkbox.style.backgroundColor = '';
            label.style.color = '';
            // Reset styles when unchecked
        }
    }
});


    </script>
