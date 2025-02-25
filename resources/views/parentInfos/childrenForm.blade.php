<x-guest-layout>
 <!-- Session Status -->
 <x-auth-session-status class="mb-4" :status="session('status')" />
 
<form action="" method="POST" enctype="multipart/form-data">
    @csrf
    <div>
        <label for="child_name">Child Name</label>
        <input type="text" name="child_name" id="child_name" required>
    </div>

    <div>
        <label for="child_birthdate">Child Birthdate</label>
        <input type="date" name="child_birthdate" id="child_birthdate" required>
    </div>

    <div>
        <label for="child_gender">Child Gender</label>
        <select name="child_gender" id="child_gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
    </div>

    <div>
        <label for="child_age">Child Age</label>
        <input type="number" name="child_age" id="child_age" min="0" required>
    </div>

    <div>
        <label for="child_birth_certificate">Child Birth Certificate</label>
        <input type="text" name="child_birth_certificate" id="child_birth_certificate" required>
    </div>

    <div>
        <label for="child_address">Child Address</label>
        <input type="text" name="child_address" id="child_address" required>
    </div>

    <div>
        <label for="child_sibling_number">Child Sibling Number</label>
        <input type="number" name="child_sibling_number" id="child_sibling_number" min="0" required>
    </div>

    <div>
        <label for="child_number">Child Number</label>
        <input type="text" name="child_number" id="child_number" required>
    </div>

    <div>
        <label for="child_allergies">Child Allergies</label>
        <textarea name="child_allergies" id="child_allergies"></textarea>
    </div>

    <div>
        <label for="child_medical_conditions">Child Medical Conditions</label>
        <textarea name="child_medical_conditions" id="child_medical_conditions"></textarea>
    </div>

    <div>
        <label for="child_previous_childcare">Child Previous Childcare</label>
        <textarea name="child_previous_childcare" id="child_previous_childcare"></textarea>
    </div>

    <div>
        <label for="birth_certificate">Birth Certificate</label>
        <input type="text" name="birth_certificate" id="birth_certificate" required>
    </div>

    <div>
        <label for="immunization_record">Immunization Record</label>
        <input type="text" name="immunization_record" id="immunization_record" required>
    </div>

    <div>
        <label for="children_photo">Children Photo</label>
        <input type="file" name="children_photo" id="children_photo">
    </div>

    <div>
        <label for="registration_status">Registration Status</label>
        <select name="registration_status" id="registration_status" required>
            <option value="Pending">Pending</option>
            <option value="Completed">Completed</option>
        </select>
    </div>

    <button type="submit">Register Child</button>
</form>
</x-guest-layout>