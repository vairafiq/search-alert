import React, { useState } from 'react';

const Modal = props => {

    return (
        <React.Fragment>
            <span className={props.status === "open" ? "wpax-vm-overlay exlac-vm-show" : "wpax-vm-overlay"}></span>
            <div className={props.status === "open" ? "exlac-vm-modal exlac-vm-modal-basic exlac-vm-show" : "exlac-vm-modal exlac-vm-modal-basic"}>
                <div className="exlac-vm-modal__header">
                    <h2 className="exlac-vm-modal-title">{props.title}</h2>
                    <a href="#" className="exlac-vm-modal-close" onClick={props.handleCancel}><span className="dashicons dashicons-no"></span></a>
                </div>
                <div className="exlac-vm-modal__body">
                    {props.children}
                </div>
                <div className="exlac-vm-modal__footer">
                    <div className="exlac-vm-modal-footer__action">
                        <a href="#" className="exlac-vm-modal-footer__action--cancel" onClick={props.handleCancel}>Cancel</a>
                        <a href="#" className="exlac-vm-modal-footer__action--ok" onClick={props.handleOk}>Ok</a>
                    </div>
                </div>
            </div>
        </React.Fragment>

    );
};

export default Modal;