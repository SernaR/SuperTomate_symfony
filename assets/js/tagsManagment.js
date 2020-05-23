import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';

import adminAPI from './services/adminAPI'
/*
const Tags = ({ recipeId }) => {

    useEffect( () => {
        fetchTags()
    }, [])

    const fetchTags = async () => {
        try {
            const tags = await adminAPI.getTags()
            setTags(tags)    
        } catch(err) {
            alert("Oups, un problème est survenue")
        } 
    }
    
    const [count, setCount] = useState(0)
    const [tags, setTags] = useState([])

    const handleClick = async tag => {
        if (!tag.selected && count < 3) {
            try {
                await adminAPI.addTag(recipeId, tag.id)
                setCount(count + 1)
            } catch (error) {
                console.log(error)
                return
            }      
        } else if (tag.selected) {
            try {
                await adminAPI.removeTag(recipeId, tag.id)
                setCount(count-1)
            } catch (error) {
                alert('oups, une erreur est survenue')
                return
            } 
        } else {
            return
        }
        tag.selected = !tag.selected
        setTags([...tags])
    }

    return ( <>
         { tags.map( (tag, index) => <Tag
                key={ index } 
                name={ tag.name }  
                color={ tag.selected ? 'primary' : 'secondary' }
                onClick={() => handleClick(tag)}/>
            )}
            <p><span className="small">Limité à 3 badges maximum</span></p>
    </> );
}*/

/*const Tag = ({name, color="secondary", onClick }) =>   
    <span
        className={ "badge ml-1" + (" pointer badge-" + color) } 
        onClick={ onClick }
        >{ name }
    </span>


const tagsComponent = document.querySelector('#tagsComponent')
const recipeId = tagsComponent.dataset.recipe 

ReactDOM.render(<Tags recipeId={ recipeId }/>, tagsComponent);
*/

const Tag = ({recipeId, name, id }) => {

    const [selected, setSelected] = useState(false)
    const handleClick = async () => {
        if (!selected) {
            try {
                await adminAPI.addTag(recipeId, id)
            } catch (error) {
                console.log(error)
                return
            }      
        } 
        if (selected) {
            try {
               await adminAPI.removeTag(recipeId, id)
            } catch (error) {
                alert('oups, une erreur est survenue')
                return
            } 
        } 
        setSelected(!selected)
    }

    return (
        <span
            className={ "badge ml-1" + (" pointer badge-" + (selected ? 'primary' : 'secondary')) } 
            onClick={ handleClick }
            >{ name }
        </span>
    )
}

document.querySelectorAll('span.react-tag').forEach(function(span) {
    const {recipe, name, id } = span.dataset
    ReactDOM.render(<Tag recipeId={recipe} name={name} id={id}/>, span);
})