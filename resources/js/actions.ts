// USER {
    export const getUser = () => ({
        type: 'GET_USER',
    });

    export const getUserByID = (id: Number,) => ({
        type: 'GET_USER_BY_ID',
        payload: id,
    });

    export const createUser = (name: String, email: String, password: String) => ({
        type: 'CREATE_USER',
        payload: {
            name: name,
            email: email,
            password: password
        },
    });

    export const updateUser = (id: Number, name: String, email: String, password: String) => ({
        type: 'UPDATE_USER',
        payload: {
            id: id,
            name: name,
            email: email,
            password: password
        },
    });

    export const deleteTenant = (id: Number) => ({
        type: 'DELETE_USER',
        payload: id,
    });
// } USER

// USERFILE {
    export const getUserfile = () => ({
        type: 'GET_USERFILE',
    });
    
    export const getUserfileByID = (id: Number,) => ({
        type: 'GET_USERFILE_BY_ID',
        payload: id,
    });
    
    export const createUserfile = (name: String, email: String, password: String) => ({
        type: 'CREATE_USERFILE',
        payload: {
            name: name,
            email: email,
            password: password
        },
    });
    
    export const updateUserfile = (id: Number, name: String, email: String, password: String) => ({
        type: 'UPDATE_USERFILE',
        payload: {
            id: id,
            name: name,
            email: email,
            password: password
        },
      });
    
    export const deleteUserfile = (id: Number) => ({
        type: 'DELETE_USERFILE',
        payload: id,
    });
// } USERFILE

// MEMBERCONFIRMATION {
    export const getMemberconfirmation = () => ({
        type: 'GET_MEMBERCONFIRMATION',
    });
    
    export const getMemberconfirmationByID = (id: Number,) => ({
        type: 'GET_MEMBERCONFIRMATION_BY_ID',
        payload: id,
    });
    
    export const createMemberconfirmation = (name: String, email: String, password: String) => ({
        type: 'CREATE_MEMBERCONFIRMATION',
        payload: {
            name: name,
            email: email,
            password: password
        },
    });
    
    export const updateMemberconfirmation = (id: Number, name: String, email: String, password: String) => ({
        type: 'UPDATE_MEMBERCONFIRMATION',
        payload: {
            id: id,
            name: name,
            email: email,
            password: password
        },
      });
    
    export const deleteMemberconfirmation = (id: Number) => ({
        type: 'DELETE_MEMBERCONFIRMATION',
        payload: id,
    });    
// } MEMBERCONFIRMATION

// MYMEMBER { 
    export const getMymember = () => ({
        type: 'GET_MYMEMBER',
    });
    
    export const getMymemberByID = (id: Number,) => ({
        type: 'GET_MYMEMBER_BY_ID',
        payload: id,
    });
    
    export const createMymember = (name: String, email: String, password: String) => ({
        type: 'CREATE_MYMEMBER',
        payload: {
            name: name,
            email: email,
            password: password
        },
    });
    
    export const updateMymember = (id: Number, name: String, email: String, password: String) => ({
        type: 'UPDATE_MYMEMBER',
        payload: {
            id: id,
            name: name,
            email: email,
            password: password
        },
      });
    
    export const deleteMymember = (id: Number) => ({
        type: 'DELETE_MYMEMBER',
        payload: id,
    });
// } MYMEMBER

// MEMBEROF { 
    export const getMemberof = () => ({
        type: 'GET_MEMBEROF',
    });
    
    export const getMemberofByID = (id: Number,) => ({
        type: 'GET_MEMBEROF_BY_ID',
        payload: id,
    });
    
    export const createMemberof = (name: String, email: String, password: String) => ({
        type: 'CREATE_MEMBEROF',
        payload: {
            name: name,
            email: email,
            password: password
        },
    });
    
    export const updateMemberof = (id: Number, name: String, email: String, password: String) => ({
        type: 'UPDATE_MEMBEROF',
        payload: {
            id: id,
            name: name,
            email: email,
            password: password
        },
      });
    
    export const deleteMemberof = (id: Number) => ({
        type: 'DELETE_MEMBEROF',
        payload: id,
    });
// } MEMBEROF