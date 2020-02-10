<div class="form-group row align-items-center" :class="{'has-danger': errors.has('user_id'), 'has-success': fields.user_id && fields.user_id.valid }">
    <label for="user_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.volunteer-info.columns.user_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.user_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('user_id'), 'form-control-success': fields.user_id && fields.user_id.valid}" id="user_id" name="user_id" placeholder="{{ trans('admin.volunteer-info.columns.user_id') }}">
        <div v-if="errors.has('user_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('user_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('id_number'), 'has-success': fields.id_number && fields.id_number.valid }">
    <label for="id_number" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.volunteer-info.columns.id_number') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.id_number" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('id_number'), 'form-control-success': fields.id_number && fields.id_number.valid}" id="id_number" name="id_number" placeholder="{{ trans('admin.volunteer-info.columns.id_number') }}">
        <div v-if="errors.has('id_number')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('id_number') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('alias'), 'has-success': fields.alias && fields.alias.valid }">
    <label for="alias" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.volunteer-info.columns.alias') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.alias" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('alias'), 'form-control-success': fields.alias && fields.alias.valid}" id="alias" name="alias" placeholder="{{ trans('admin.volunteer-info.columns.alias') }}">
        <div v-if="errors.has('alias')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('alias') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('gender'), 'has-success': fields.gender && fields.gender.valid }">
    <label for="gender" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.volunteer-info.columns.gender') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.gender" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('gender'), 'form-control-success': fields.gender && fields.gender.valid}" id="gender" name="gender" placeholder="{{ trans('admin.volunteer-info.columns.gender') }}">
        <div v-if="errors.has('gender')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('gender') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('birthday'), 'has-success': fields.birthday && fields.birthday.valid }">
    <label for="birthday" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.volunteer-info.columns.birthday') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-sm-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.birthday" :config="datePickerConfig" v-validate="'required|date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('birthday'), 'form-control-success': fields.birthday && fields.birthday.valid}" id="birthday" name="birthday" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_a_date') }}"></datetime>
        </div>
        <div v-if="errors.has('birthday')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('birthday') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('education'), 'has-success': fields.education && fields.education.valid }">
    <label for="education" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.volunteer-info.columns.education') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.education" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('education'), 'form-control-success': fields.education && fields.education.valid}" id="education" name="education" placeholder="{{ trans('admin.volunteer-info.columns.education') }}">
        <div v-if="errors.has('education')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('education') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('organisation'), 'has-success': fields.organisation && fields.organisation.valid }">
    <label for="organisation" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.volunteer-info.columns.organisation') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.organisation" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('organisation'), 'form-control-success': fields.organisation && fields.organisation.valid}" id="organisation" name="organisation" placeholder="{{ trans('admin.volunteer-info.columns.organisation') }}">
        <div v-if="errors.has('organisation')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('organisation') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('mobile_number'), 'has-success': fields.mobile_number && fields.mobile_number.valid }">
    <label for="mobile_number" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.volunteer-info.columns.mobile_number') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.mobile_number" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('mobile_number'), 'form-control-success': fields.mobile_number && fields.mobile_number.valid}" id="mobile_number" name="mobile_number" placeholder="{{ trans('admin.volunteer-info.columns.mobile_number') }}">
        <div v-if="errors.has('mobile_number')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('mobile_number') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('address'), 'has-success': fields.address && fields.address.valid }">
    <label for="address" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.volunteer-info.columns.address') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.address" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('address'), 'form-control-success': fields.address && fields.address.valid}" id="address" name="address" placeholder="{{ trans('admin.volunteer-info.columns.address') }}">
        <div v-if="errors.has('address')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('address') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('interests'), 'has-success': fields.interests && fields.interests.valid }">
    <label for="interests" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.volunteer-info.columns.interests') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.interests" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('interests'), 'form-control-success': fields.interests && fields.interests.valid}" id="interests" name="interests" placeholder="{{ trans('admin.volunteer-info.columns.interests') }}">
        <div v-if="errors.has('interests')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('interests') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('emergency_contact'), 'has-success': fields.emergency_contact && fields.emergency_contact.valid }">
    <label for="emergency_contact" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.volunteer-info.columns.emergency_contact') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.emergency_contact" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('emergency_contact'), 'form-control-success': fields.emergency_contact && fields.emergency_contact.valid}" id="emergency_contact" name="emergency_contact" placeholder="{{ trans('admin.volunteer-info.columns.emergency_contact') }}">
        <div v-if="errors.has('emergency_contact')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('emergency_contact') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('volunteer_experences'), 'has-success': fields.volunteer_experences && fields.volunteer_experences.valid }">
    <label for="volunteer_experences" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.volunteer-info.columns.volunteer_experences') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.volunteer_experences" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('volunteer_experences'), 'form-control-success': fields.volunteer_experences && fields.volunteer_experences.valid}" id="volunteer_experences" name="volunteer_experences" placeholder="{{ trans('admin.volunteer-info.columns.volunteer_experences') }}">
        <div v-if="errors.has('volunteer_experences')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('volunteer_experences') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('references'), 'has-success': fields.references && fields.references.valid }">
    <label for="references" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.volunteer-info.columns.references') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.references" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('references'), 'form-control-success': fields.references && fields.references.valid}" id="references" name="references" placeholder="{{ trans('admin.volunteer-info.columns.references') }}">
        <div v-if="errors.has('references')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('references') }}</div>
    </div>
</div>


