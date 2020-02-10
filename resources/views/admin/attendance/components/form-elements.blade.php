<div class="form-group row align-items-center" :class="{'has-danger': errors.has('arrived_at'), 'has-success': fields.arrived_at && fields.arrived_at.valid }">
    <label for="arrived_at" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.attendance.columns.arrived_at') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.arrived_at" :config="datetimePickerConfig" v-validate="'required|date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('arrived_at'), 'form-control-success': fields.arrived_at && fields.arrived_at.valid}" id="arrived_at" name="arrived_at" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_date_and_time') }}"></datetime>
        </div>
        <div v-if="errors.has('arrived_at')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('arrived_at') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('left_at'), 'has-success': fields.left_at && fields.left_at.valid }">
    <label for="left_at" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.attendance.columns.left_at') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.left_at" :config="datetimePickerConfig" v-validate="'date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('left_at'), 'form-control-success': fields.left_at && fields.left_at.valid}" id="left_at" name="left_at" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_date_and_time') }}"></datetime>
        </div>
        <div v-if="errors.has('left_at')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('left_at') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('activity_id'), 'has-success': fields.activity_id && fields.activity_id.valid }">
    <label for="activity_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.attendance.columns.activity_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.activity_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('activity_id'), 'form-control-success': fields.activity_id && fields.activity_id.valid}" id="activity_id" name="activity_id" placeholder="{{ trans('admin.attendance.columns.activity_id') }}">
        <div v-if="errors.has('activity_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('activity_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('user_id'), 'has-success': fields.user_id && fields.user_id.valid }">
    <label for="user_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.attendance.columns.user_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.user_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('user_id'), 'form-control-success': fields.user_id && fields.user_id.valid}" id="user_id" name="user_id" placeholder="{{ trans('admin.attendance.columns.user_id') }}">
        <div v-if="errors.has('user_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('user_id') }}</div>
    </div>
</div>


