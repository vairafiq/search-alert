const actions = {
  SIDEBAR_ITEM_CHANGE_BEGIN: 'SIDEBAR_ITEM_CHANGE_BEGIN',
  SIDEBAR_ITEM_CHANGE_SUCCESS: 'SIDEBAR_ITEM_CHANGE_SUCCESS',
  SIDEBAR_ITEM_CHANGE_ERR: 'SIDEBAR_ITEM_CHANGE_ERR',

  sidebarItemChangeBegin: () => {
    return {
      type: actions.SIDEBAR_ITEM_CHANGE_BEGIN,
    };
  },

  sidebarItemChangeSuccess: status => {
    return {
      type: actions.SIDEBAR_ITEM_CHANGE_SUCCESS,
      status,
    };
  },

  sidebarItemChangeError: err => {
    return {
      type: actions.SIDEBAR_ITEM_CHANGE_ERR,
      err,
    };
  }
};
  
export default actions;
  