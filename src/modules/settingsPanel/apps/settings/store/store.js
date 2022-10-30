import { applyMiddleware } from 'redux';
import { configureStore } from "@reduxjs/toolkit";
import thunk from 'redux-thunk';
import { composeWithDevTools } from 'redux-devtools-extension';
import rootReducer from './rootReducers';

const store = configureStore({reducer: rootReducer}, composeWithDevTools(applyMiddleware(thunk.withExtraArgument())));

export default store;