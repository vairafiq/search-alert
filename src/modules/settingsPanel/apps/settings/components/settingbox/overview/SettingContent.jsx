import { useState } from "react";
import { useDispatch } from "react-redux";
import { ReactSVG } from 'react-svg';
import { Multiselect } from "multiselect-react-dropdown";
import handRight from 'Assets/svg/icons/hand-right.svg';
import Switch from "react-switch";
import { SettingContentWrap } from '../Style';
import api from '../../settingbox/../../helpers/api';

const defaultTemplateBody = `Dear User,

Thank You For Sharing Your Concern. 

The post you were searching is just found! Let\'s check this out from the link {{POST_LINK}}

Thanks,
The Administrator`;

const SettingContent = props => {

    const { optionState, setOptionState } = props;
    const { emailBody, enable_search_alert, excludedPages, included_single_post, defaultRole, optionLoader, loader, email_footer, emailSubject, context, cancelOnTapOutside, parentDomain, delay, updateExistingUser } = optionState;
    const dispatch = useDispatch();

    const fetchOptions = async ()=>{
        const optionResponse = await api.getOptions()
        return optionResponse;
    }
    fetchOptions()
        .then( optionResponse => {
            if( optionLoader ) return;
            let options = optionResponse.data.data;
            setOptionState({
                ...optionState,
                optionLoader: true,
                emailBody: typeof(options['emailBody']) !== 'undefined' ? options['emailBody'] : '',
                enable_search_alert: typeof(options['enable_search_alert']) !== 'undefined' ? options['enable_search_alert'] : true,
                excludedPages: typeof(options['excludedPages']) !== 'undefined' ? options['excludedPages'] : [],
                included_single_post: typeof(options['included_single_post']) !== 'undefined' ? options['included_single_post'] : [],
                defaultRole: typeof(options['defaultRole']) !== 'undefined' ? options['defaultRole'] : 'subscriber',
                email_footer: typeof(options['email_footer']) !== 'undefined' ? options['email_footer'] : true,
                emailSubject: typeof(options['emailSubject']) !== 'undefined' ? options['emailSubject'] : '',
                context: typeof(options['context']) !== 'undefined' ? options['context'] : 'signin',
                cancelOnTapOutside: typeof(options['cancelOnTapOutside']) !== 'undefined' ? options['cancelOnTapOutside'] : false,
                parentDomain: typeof(options['parentDomain']) !== 'undefined' ? options['parentDomain'] : '',
                delay: typeof(options['delay']) !== 'undefined' ? options['delay'] : '',
                updateExistingUser: typeof(options['updateExistingUser']) !== 'undefined' ? options['updateExistingUser'] : false,

            });
        })
        .catch((error) => {
            console.log(error);
        })


    const handleSearchAlertToggle = (e) => { 
        setOptionState({
            ...optionState,
            enable_search_alert: !enable_search_alert,
        });
    }

    const handleemailBody = (e) => { 
        setOptionState({
            ...optionState,
            emailBody: e.target.value
        });

    }
    const handleExcludedPages = ( selectedList, selectedItem ) => { 
        setOptionState({
            ...optionState,
            excludedPages: selectedList
        });

    }

    const handlEincluded_single_post = ( selectedList, selectedItem ) => { 
        setOptionState({
            ...optionState,
            included_single_post: selectedList
        });

    }

    const handlDefaultRole = ( selectedList, selectedItem ) => { 
        setOptionState({
            ...optionState,
            defaultRole: selectedList
        });
    }
    const handleAutoSignIn = (e) => { 
        setOptionState({
            ...optionState,
            email_footer: !email_footer,
        });
    }
    const handleRedirect = (e) => { 
        setOptionState({
            ...optionState,
            emailSubject: e.target.value
        });
    }
    const handlContext = ( selectedList, selectedItem ) => { 
        setOptionState({
            ...optionState,
            context: selectedList
        });
    }
    const handleCancelOnTapOutside = (e) => { 
        setOptionState({
            ...optionState,
            cancelOnTapOutside: !cancelOnTapOutside,
        });
    }
    const handleParentDomain = (e) => { 
        setOptionState({
            ...optionState,
            parentDomain: e.target.value
        });
    }
    const handleDelay = (e) => { 
        setOptionState({
            ...optionState,
            delay: e.target.value
        });
    }

    const handleUpdateExistingUser = (e) => { 
        setOptionState({
            ...optionState,
            updateExistingUser: !updateExistingUser,
        });
    }

    // console.log( enable_search_alert );
    const SettingContentData = [
        {
            key: "general",
            content: [
                {
                    label: "Enable Search Alert",
                    component: <div className="exlac-vm-setting-has-info">
                        <Switch uncheckedIcon={false} checkedIcon={false} onColor="#6551F2" offColor="#E2E2E2" className="exlac-vm-switch" handleDiameter={14} height={22} width={40} name="enable_search_alert" checked={enable_search_alert} onChange={handleSearchAlertToggle} />
                    </div>
                },
                {
                    label: "Send Alert for Post Type",
                    component: <Multiselect selectionLimit='1' selectedValues={included_single_post} onSelect={handlEincluded_single_post} placeholder="Select Post Types" options={searchAlert_SettingsScriptData.wp_post_types} displayValue="title" />
                },
                {
                    label: "Email Subject",
                    component: <div className="exlac-vm-form-group">
                        <input type="url" name="emailSubject" className="exlac-vm-form__element" id="exlac-vm-chat-btn-text" value={emailSubject || 'New Post Alert'} onChange={handleRedirect} />
                    </div>
                },
                {
                    label: "Email Body",
                    pro: false,
                    component: <div className="exlac-vm-form-group">
                        <textarea
                            className='exlac-vm-form__element'
                            id='exlac-vm-mail-from-body'
                            name='emailBody'
                            placeholder=''
                            defaultValue={
                                emailBody || defaultTemplateBody
                            }
                            onChange={handleemailBody}
                        />
                    </div>
                },
                {
                    label: "Email Footer",
                    pro: false,
                    component: <div className="exlac-vm-setting-has-info">
                        <Switch uncheckedIcon={false} checkedIcon={false} onColor="#6551F2" offColor="#E2E2E2" className="exlac-vm-switch" handleDiameter={14} height={22} width={40} name="email_footer" checked={email_footer} onChange={handleAutoSignIn} />
                    </div>
                },
                
            ]
        }
    ];

    // console.log(optionState)

    return (
        <SettingContentWrap className="search-alert-settings-inner">
            <form action="" id="search_alert_option_panel">
                {
                    SettingContentData.filter(item => item.key == "general")[0].content.map((settingItem, index) => {
                        let type = settingItem.pro ? 'search-alert-settings__single search-alert-pro-element' : 'search-alert-settings__single';
                        return (
                            <div className={type} key={index}>
                                <h4 className="search-alert-settings__single--label">{settingItem.label}
                                {
                                    settingItem.pro &&
                                    <sup className="search-alert-pro-badge">Pro</sup>
                                }
                                </h4>
                                <div className="search-alert-settings__single--element">
                                    {
                                        settingItem.component
                                    }
                                </div>
                            </div>
                        )
                    })
                }
            </form>

        </SettingContentWrap>
    );
}

export default SettingContent;