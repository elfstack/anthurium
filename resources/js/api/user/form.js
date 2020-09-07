import index from "../listing";

export default {
    questions (id) {
        return window.axios.get(`/forms/${id}/questions`)
    }
}
