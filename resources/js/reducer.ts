const user = (state = [], action) => {
    switch (action.type) {
        case "GET_USER":
            return action.payload;
        case "GET_USER_BY_ID":
            const model = action.payload;
            const index = state.findIndex((item) => item.id === model.id);
            if (index !== -1) {
                state[index] = model;
            }
            return state;
        case "CREATE_USER":
            return [...state, action.payload];
        case "UPDATE_USER":
            const index = state.findIndex((model) => model.id === action.payload.id);
            state[index] = action.payload;
            return state;
        case "DELETE_USER":
            return state.filter((model) => model.id !== action.payload.id);
        default:
            return state;
    }
};

const userfile = (state = [], action) => {
    switch (action.type) {
        case "GET_USERFILE":
            return action.payload;
        case "GET_USERFILE_BY_ID":
            const model = action.payload;
            const index = state.findIndex((item) => item.id === model.id);
            if (index !== -1) {
                state[index] = model;
            }
            return state;
        case "CREATE_USERFILE":
            return [...state, action.payload];
        case "UPDATE_USERFILE":
            const index = state.findIndex((model) => model.id === action.payload.id);
            state[index] = action.payload;
            return state;
        case "DELETE_USERFILE":
            return state.filter((model) => model.id !== action.payload.id);
        default:
            return state;
    }
};

const memberconfirmation = (state = [], action) => {
    switch (action.type) {
        case "GET_MEMBERCONFIRMATION":
            return action.payload;
        case "GET_MEMBERCONFIRMATION_BY_ID":
            const model = action.payload;
            const index = state.findIndex((item) => item.id === model.id);
            if (index !== -1) {
                state[index] = model;
            }
            return state;
        case "CREATE_MEMBERCONFIRMATION":
            return [...state, action.payload];
        case "UPDATE_MEMBERCONFIRMATION":
            const index = state.findIndex((model) => model.id === action.payload.id);
            state[index] = action.payload;
            return state;
        case "DELETE_MEMBERCONFIRMATION":
            return state.filter((model) => model.id !== action.payload.id);
        default:
            return state;
    }
};

const mymember = (state = [], action) => {
    switch (action.type) {
        case "GET_MYMEMBER":
            return action.payload;
        case "GET_MYMEMBER_BY_ID":
            const model = action.payload;
            const index = state.findIndex((item) => item.id === model.id);
            if (index !== -1) {
                state[index] = model;
            }
            return state;
        case "CREATE_MYMEMBER":
            return [...state, action.payload];
        case "UPDATE_MYMEMBER":
            const index = state.findIndex((model) => model.id === action.payload.id);
            state[index] = action.payload;
            return state;
        case "DELETE_MYMEMBER":
            return state.filter((model) => model.id !== action.payload.id);
        default:
            return state;
    }
};

const memberof = (state = [], action) => {
    switch (action.type) {
        case "GET_MEMBEROF":
            return action.payload;
        case "GET_MEMBEROF_BY_ID":
            const model = action.payload;
            const index = state.findIndex((item) => item.id === model.id);
            if (index !== -1) {
                state[index] = model;
            }
            return state;
        case "CREATE_MEMBEROF":
            return [...state, action.payload];
        case "UPDATE_MEMBEROF":
            const index = state.findIndex((model) => model.id === action.payload.id);
            state[index] = action.payload;
            return state;
        case "DELETE_MEMBEROF":
            return state.filter((model) => model.id !== action.payload.id);
        default:
            return state;
    }
};