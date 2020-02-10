<div class="form-group row align-items-center" :class="{'has-danger': errors.has('enrolled_at'), 'has-success': fields.enrolled_at && fields.enrolled_at.valid }">
    <label for="enrolled_at" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.participant.columns.enrolled_at') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.enrolled_at" :config="datetimePickerConfig" v-validate="'required|date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('enrolled_at'), 'form-control-success': fields.enrolled_at && fields.enrolled_at.valid}" id="enrolled_at" name="enrolled_at" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_date_and_time') }}"></datetime>
        </div>
        <div v-if="errors.has('enrolled_at')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('enrolled_at') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('activity_id'), 'has-success': fields.activity_id && fields.activity_id.valid }">
    <label for="activity_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.participant.columns.activity_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.activity_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('activity_id'), 'form-control-success': fields.activity_id && fields.activity_id.valid}" id="activity_id" name="activity_id" placeholder="{{ trans('admin.participant.columns.activity_id') }}">
        <div v-if="errors.has('activity_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('activity_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('user_id'), 'has-success': fields.user_id && fields.user_id.valid }">
    <label for="user_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.participant.columns.user_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.user_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('user_id'), 'form-control-success': fields.user_id && fields.user_id.valid}" id="user_id" name="user_id" placeholder="{{ trans('admin.participant.columns.user_id') }}">
        <div v-if="errors.has('user_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('user_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('attendance_id'), 'has-success': fields.attendance_id && fields.attendance_id.valid }">
    <label for="attendance_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.participant.columns.attendance_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.attendance_id" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('attendance_id'), 'form-control-success': fields.attendance_id && fields.attendance_id.valid}" id="attendance_id" name="attendance_id" placeholder="{{ trans('admin.participant.columns.attendance_id') }}">
        <div v-if="errors.has('attendance_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('attendance_id') }}</div>
    </div>
</div>


