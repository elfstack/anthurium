@extends('admin.activity.layout')

@section('contents')
    <activity-budget :id="{{ $activity->id }}" inline-template>
        <div class="container-xl mt-5">
            <modal name="edit-budget"
                   height="auto"
                   @before-open="(e) => modalParams = e.params">
                @include('admin.budget.create')
            </modal>
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            Budgets
                            <button class="btn btn-primary float-right" @click="showEditBudget">
                                Add Expense
                            </button>
                        </div>

                        <div class="list-group list-group-flush" v-for="(item, key) in data.details">
                            <a href="#" class="list-group-item list-group-item-action active">
                                @{{ key }}
                                <!-- TODO: span class="badge badge-pill badge-secondary float-right">$264.00 | +$0.00</span -->
                            </a>
                            <a href="#" class="list-group-item list-group-item-action" v-for="entry in item" @click="showEditBudget(entry.id, entry)">
                                <p class="mb-0">@{{ entry.name }}
                                    <span class="badge badge-pill float-right"
                                          :class="diff(entry) > 0 ? 'badge-danger' : 'badge-success'">@{{ diff(entry) | money }}</span>
                                </p>
                                <small>Estimated: $@{{ entry.budget }}, Actual: $@{{ entry.expense }}</small>
                            </a>
                        </div>

                        <div class="card-footer">
                            Total Estimated: $@{{ data.totalBudgets }}, Actual Expense: $@{{ data.totalExpenses }}
                        </div>
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="card text-primary bg-white">
                        <div class="card-body">
                            <div>Summary</div>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-success" role="progressbar"
                                     style="width: 80%"
                                     aria-valuenow="80" aria-valuemin="0"
                                     aria-valuemax="100"></div>
                                <div class="progress-bar bg-danger" role="progressbar"
                                     v-if="'extras' in expensePercentages"
                                     :style="`width: ${expensePercentages.extras}%`"
                                     :aria-valuenow="expensePercentages.extras" aria-valuemin="0"
                                     aria-valuemax="100"></div>
                                <div class="progress-bar bg-info" role="progressbar"
                                     v-if="'surplus' in expensePercentages"
                                     :style="`width: ${expensePercentages.surplus}%`"
                                     :aria-valuenow="expensePercentages.surplus" aria-valuemin="0"
                                     aria-valuemax="100"></div>
                            </div>

                        </div>

                        <div class="card-footer pt-0">
                            <p class="mb-0">Total Estimated: $@{{ data.totalBudgets }}</p>
                            <p class="mb-0">Actual Expense: $@{{ data.totalExpenses }}</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </activity-budget>
@endsection
