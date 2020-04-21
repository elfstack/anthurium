<template>

</template>

<script>
    export default {
        name: "ActivityBudgets",
        props: {
            id: {
                type: Number,
                required: true
            }
        },
        data () {
            return {
                data: {},
                modalParams: {
                    action: '',
                    data: null
                }
            }
        },
        computed: {
            diff () {
                return (entry) => entry.expense - entry.budget
            },
            expensePercentages () {
                const difference = this.data.totalBudgets - this.data.totalExpenses;

                console.log(difference)

                if (difference > 0) {
                   // show budgets and surplus
                    return {
                        budgets: 100,
                        surplus: difference / this.data.totalBudgets * 100
                    }
                } else {
                    // show budgets and extras
                    return {
                        budgets: this.data.totalBudgets / this.data.totalExpenses * 100,
                        extras:  difference / this.data.totalBudgets * -100
                    }
                }
            }
        },
        filters: {
            money (value) {
                let sign = value > 0 ? '-' : '+';
                value = Math.abs(value)
                let val = (value/1).toFixed(2).replace('.', ',')
                return sign + '$' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            }
        },
        mounted () {
            this.getBudgets()
        },
        methods: {
            getBudgets () {
                window.axios.get(`/api/activity/${this.id}/budgets`).then(({data}) => {
                    this.data = data
                })
            },
            showEditBudget (budgetId, data=undefined)
            {
                let path = 'budget';
                path += budgetId ? 's' : '/' + budgetId;

                this.$modal.show('edit-budget', {
                    action: `/api/activity/${this.id}/${path}`,
                    ... (data ? { data: data } : {})
                });
            },
            updateBudgetList (data) {
                // FIXME: this needs to be fixed
                const category = data.category;
                this.data.details[category].push(data);
            }
        }
    }
</script>

<style scoped>

</style>
