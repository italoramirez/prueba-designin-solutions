export default function guest({next,store}){
    if(!store.isAuthenticated){
        return next({
            name: 'login'
        })
    }
    return next();
}
