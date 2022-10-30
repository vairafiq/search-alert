import actions from './actions';

const initialState = {
  sidebarPath: "live-chat",
  loading: false,
  error: null,
};

const {
  SIDEBAR_ITEM_CHANGE_BEGIN,
  SIDEBAR_ITEM_CHANGE_SUCCESS,
  SIDEBAR_ITEM_CHANGE_ERR,
} = actions;

const TagReducer = (state = initialState, action) => {
  const { type, data, err } = action;
  switch (type) {
    case SIDEBAR_ITEM_CHANGE_BEGIN:
      return {
        ...state,
        sLoading: true,
      };
    case SIDEBAR_ITEM_CHANGE_SUCCESS:
      return {
        ...state,
        sidebarPath: data,
        sLoading: false,
      };
    case SIDEBAR_ITEM_CHANGE_ERR:
      return {
        ...state,
        error: err,
        sLoading: false,
      };
    default:
      return state;
  }
};

export default TagReducer;