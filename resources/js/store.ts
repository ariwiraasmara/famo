import { createStore } from "redux";

const reducers = {
  user: (state = [], action: any) => {
    switch (action.type) {
      case "GET_USER":
        return action.payload;
      case "GET_USER_BY_ID":
        const model = action.payload;
        const getIndex = state.findIndex((item) => item.id === model.id);
        if (getIndex !== -1) {
          state[getIndex] = model;
        }
        return state;
      case "CREATE_USER":
        return [...state, action.payload];
      case "DELETE_USER":
        return state.filter((model) => model.id !== action.payload.id);
      case "UPDATE_USER":
        const updateIndex = state.findIndex(
          (model) => model.id === action.payload.id
        );
        state[updateIndex] = action.payload;
        return state;
      default:
        return state;
    }
  },
  userfile: (state = [], action: any) => {
    switch (action.type) {
      case "GET_USERFILE":
        return action.payload;
      case "GET_USER_BY_ID":
        const model = action.payload;
        const getIndex = state.findIndex((item) => item.id === model.id);
        if (getIndex !== -1) {
          state[getIndex] = model;
        }
        return state;
      case "CREATE_USERFILE":
        return [...state, action.payload];
      case "DELETE_USERFILE":
        return state.filter((model) => model.id !== action.payload.id);
      case "UPDATE_USERFILE":
        const updateIndex = state.findIndex(
          (model) => model.id === action.payload.id
        );
        state[updateIndex] = action.payload;
        return state;
      default:
        return state;
    }
  },
  memberconfirmation: (state = [], action: any) => {
    switch (action.type) {
      case "GET_MEMBERCONFIRMATION":
        return action.payload;
      case "GET_USER_BY_ID":
        const model = action.payload;
        const getIndex = state.findIndex((item) => item.id === model.id);
        if (getIndex !== -1) {
          state[getIndex] = model;
        }
        return state;
      case "CREATE_MEMBERCONFIRMATION":
        return [...state, action.payload];
      case "DELETE_MEMBERCONFIRMATION":
        return state.filter((model) => model.id !== action.payload.id);
      case "UPDATE_MEMBERCONFIRMATION":
        const updateIndex = state.findIndex(
          (model) => model.id === action.payload.id
        );
        state[updateIndex] = action.payload;
        return state;
      default:
        return state;
    }
  },
  mymember: (state = [], action: any) => {
    switch (action.type) {
      case "GET_MYMEMBER":
        return action.payload;
      case "GET_USER_BY_ID":
        const model = action.payload;
        const getIndex = state.findIndex((item) => item.id === model.id);
        if (getIndex !== -1) {
          state[getIndex] = model;
        }
        return state;
      case "CREATE_MYMEMBER":
        return [...state, action.payload];
      case "DELETE_MYMEMBER":
        return state.filter((model) => model.id !== action.payload.id);
      case "UPDATE_MYMEMBER":
        const updateIndex = state.findIndex(
          (model) => model.id === action.payload.id
        );
        state[updateIndex] = action.payload;
        return state;
      default:
        return state;
    }
  },
  memberof: (state = [], action: any) => {
    switch (action.type) {
      case "GET_MEMBEROF":
        return action.payload;
      case "GET_USER_BY_ID":
        const model = action.payload;
        const getIndex = state.findIndex((item) => item.id === model.id);
        if (getIndex !== -1) {
          state[getIndex] = model;
        }
        return state;
      case "CREATE_MEMBEROF":
        return [...state, action.payload];
      case "DELETE_MEMBEROF":
        return state.filter((model) => model.id !== action.payload.id);
      case "UPDATE_MEMBEROF":
        const updateIndex = state.findIndex(
          (model) => model.id === action.payload.id
        );
        state[updateIndex] = action.payload;
        return state;
      default:
        return state;
    }
  },  
};

const store = createStore(reducers);
export default store;
