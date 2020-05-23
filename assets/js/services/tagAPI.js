import axios from 'axios'
import { ADMIN_API } from './config.js';

function addTag(recipeId, tag) {
    return axios
        .put(ADMIN_API + 'recipe/addTag/'+ recipeId + '/' + tag)
        .then(result => result.data)
}

function removeTag(recipeId, tag) {
    return axios
        .put(ADMIN_API + 'recipe/removeTag/'+ recipeId + '/' + tag)
        .then(result => result.data)
}

export default { removeTag, addTag }
