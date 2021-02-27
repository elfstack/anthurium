export default {
  findAction (type) {
   return window.axios.get('/action', {
     params: {
       type: type
     }
   })
  },
  restart (id) {
    return window.axios.patch('/action/' + id, {
      restart: true
    })
  }
}
