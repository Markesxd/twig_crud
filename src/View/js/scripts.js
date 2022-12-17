async function remove(id) {
    await fetch(`/entity/${id}`,{
        method: 'DELETE'
    });
    location.assign('/');
}