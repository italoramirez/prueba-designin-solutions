const AUTH_API_BASE_URL: string = import.meta.env.VITE_API_URL
const AUTH_API_URL: string = `${AUTH_API_BASE_URL}/api`

export const LOGIN_URL: string = `${AUTH_API_URL}/login`
export const REGISTER_URL: string = `${AUTH_API_URL}/register`
export const LOGOUT_URL: string = `${AUTH_API_URL}/logout`
