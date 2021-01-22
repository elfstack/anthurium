/**
 * Pagination wrapper for listing api not implement this.
 *
 * @param indexApi
 * @param {string} key The key to access the object.
 * @returns {function} Wrapped function
 */
export default function (indexApi, key=null)  {
  return (pagination) => indexApi().then(({data}) => {
    const list = data[key]
    return {
      data: {
        data: list,
        total: list.length
      }
    }
  })
}
