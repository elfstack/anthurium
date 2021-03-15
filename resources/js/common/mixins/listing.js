// TODO: refactor as mixin
const listing = {
    data () {
        return {
            api: null,
            columns: [],
            data: [],
            listing: {
                pagination: {
                    showSizeChanger: true
                },
                sorter: {},
                filters: {},
                keyword: ''
            },
            loading: true,
            autoload: true
        }
    },
    mounted () {
      if (this.autoload) {
        this.fetchData()
      }
    },
    methods: {
        fetchData () {
            this.loading = true
            this.api(this.listing).then(({data}) => {
                // update current page and loading status
                const pagination = { ...this.listing.pagination }
                pagination.total = data.total
                this.data = data.data
                this.listing.pagination = pagination
                this.loading = false
            }).catch(e => {
                if (e.response.status === 404) {
                    this.loading = false
                }
            })
        },
        /**
         * Handle table change
         *
         * @param pagination
         * @param filters
         * @param sorter
         */
        handleChange (pagination, filters, sorter) {
            const pager = { ...this.listing.pagination }
            pager.current = pagination.current
            pager.pageSize = pagination.pageSize
            this.listing = {
                pagination: pager,
                filters: filters,
                sorter: sorter
            }
            this.fetchData()
        },
        handlePageChange (current) {
            const pager = { ...this.listing.pagination }
            pager.current = current
            this.listing.pagination = pager
            this.fetchData()
        },
        handlePageSizeChange (current, pageSize) {
            const pager = { ...this.listing.pagination }
            pager.current = current
            pager.pageSize = pageSize
            this.listing.pagination = pager
            this.fetchData()
        },
        handleSearch (keyword) {
            this.listing.keyword = keyword
            this.fetchData()
        },
        filter (column, value) {
            this.listing.filters[column] = value
            this.fetchData()
        },
        clearFilter (column) {
            delete this.listing.filters[column]
            this.fetchData()
        },
        clearAllFilter () {
            this.listing.filters = []
            this.fetchData()
        }
    }
}

export default listing
