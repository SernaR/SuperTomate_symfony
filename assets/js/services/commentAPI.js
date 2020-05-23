import axios from 'axios'
import { USER_API, ADMIN_API } from './config.js';


function readComment(id) {
    return axios
        .put( USER_API + 'lecture/commentaire/' + id )
        .then(result => result.data)
}

function validateComment(id) {
    return axios
        .put( ADMIN_API + 'validation/commentaire/' + id )
        .then(result => result.data)
}

function blockComment(id) {
    return axios
        .put( ADMIN_API + 'bloque/commentaire/' + id )
        .then(result => result.data)
}

export default { readComment, validateComment, blockComment }
