import React from 'react';
import { ReactSVG } from 'react-svg';
import { ChatBoxPreviewWrap } from '../Style';
import largeLine from 'Assets/svg/large-line.svg';
import smallLine from 'Assets/svg/small-line.svg';
import img from 'Assets/svg/img.svg';
import plane from 'Assets/svg/icons/paper-plane.svg';
import user from 'Assets/img/settings/user.png';

const ChatBoxPreview = () => {
    return (
        <ChatBoxPreviewWrap>
            <div className="exlac-vm-chatbox-top">
                <div className="exlac-vm-chatbox-top__title">
                    <ReactSVG src={largeLine} />
                </div>
                <div className="exlac-vm-chatbox-top__imglist">
                    <ReactSVG src={img} />
                    <ReactSVG src={img} />
                    <ReactSVG src={img} />
                </div>
                <a href="#" className="exlac-vm-chatbox-btn-close">
                    <span className="dashicons dashicons-no"></span>
                </a>
            </div>
            <div className="exlac-vm-chatbox-content">
                <div className="exlac-vm-chatbox-content___inner">
                    <div className="exlac-vm-chatbox-content__img">
                        <img src={user} alt="Wpwax Video Support" />
                    </div>
                    <div className="exlac-vm-chatbox-content__text">
                        <p>Leave your questions below and we will get back to you asap.</p>
                        <a href="#" className="exlac-vm-btn exlac-vm-btn-sm exlac-vm-btn-primary">Get Started</a>
                    </div>
                </div>
            </div>
            <div className="exlac-vm-chatbox-bottom">
                <div className="exlac-vm-chatbox-bottom__text"><ReactSVG src={smallLine} /></div>
                <a href="#" className="exlac-vm-btn-send"><ReactSVG src={plane} /></a>
            </div>
        </ChatBoxPreviewWrap>
    )
}

export default ChatBoxPreview;