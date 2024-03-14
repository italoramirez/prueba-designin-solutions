export default function guest({next,store}){
    if(store.isAuthenticated){
        return next({
            name: 'home'
        })
    }
    return next();
}

