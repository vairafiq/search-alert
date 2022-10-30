import actions from './actions';

const {
  sidebarItemChangeBegin,
  sidebarItemChangeSuccess,
  sidebarItemChangeError,
} = actions;

const handleSidebarItem = status => {
  return async dispatch => {
    try {
      dispatch(sidebarItemChangeBegin());
      dispatch(sidebarItemChangeSuccess(status));
    } catch (err) {
      dispatch(sidebarItemChangeError(err));
    }
  };
};

export { handleSidebarItem };
