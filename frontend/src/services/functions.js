import axios from 'axios'
import router from "@/router";
import setAuthHeader from "@/services/setAuthHeader.js"

let url = process.env.VUE_APP_API_URL_BASE

export function register(parameters) {
    event.preventDefault()
    axios.post(url + 'auth/register', parameters).then(() => {
        window.location.replace('/login');
    }).catch(error => {
        console.log(error)
    });
}

export function login(parameters) {
    event.preventDefault()
    axios.post(url + 'auth/login', parameters).then((response) => {
        localStorage.setItem('bearerToken', response.data.data.token)
        localStorage.setItem('userName', response.data.data.user_name)
        //localStorage.setItem('userEmail', response.data.data.user_email)
        setAuthHeader(response.data.data.token)
        window.location.replace('/');
    }).catch(error => {
        console.log(error)
    });
}

export function logout() {
    event.preventDefault()
    axios.post(url + 'auth/logout').then(() => {
        localStorage.clear();
        window.location.replace('/home');
    }).catch(error => {
        console.log(error)
    });
}

export function postStory(parameters) {
    axios.post(url + 'stories', parameters).then((response) => {
        if (response.data.message === 'Story Created') {
            router.push('/')
        } else if (response.data.message === 'Something Error') {
            alert('Please Rewrite the Product');
        }
    }).catch(error => {
        if (error.response.data.message == 'Data Invalid') {
            let list = '';
            let errors = error.response.data.errors
            Object.keys(errors).forEach(
                key => list += errors[key][0] + '\n'
            );
            alert(list, 'error');
        }
    });
}

export function putStory(id, parameters) {
    axios.put(url + 'stories/' + id, parameters).then((response) => {
        console.log(response)
        let status = response.data.status
        let url = response.data.redirect
        if (status === 'success') {
            window.location.replace('/story/' + url);
        } else {
            router.push('/profile')
        }
    }).catch(error => {
        console.log(error)
    });
}

export function deleteStory(id) {
    axios.delete('http://localhost/api/stories/' + id).then((response) => {
        let status = response.data.status
        if (status === 'success') {
            router.push('/profile')
        } else {
            router.push('/profile')
        }
    }).catch(error => {
        console.log(error)
    });
}

export function updateProfileInfo(parameters) {
    axios.post(url + 'user/update', parameters).then((response) => {
        let status = response.data.status;
        if (status === 'success') {
            router.push('/me/settings/account')
        } else {
            alert('Deu ruim')
        }
    }).catch(error => {
        console.log(error)
    });
}