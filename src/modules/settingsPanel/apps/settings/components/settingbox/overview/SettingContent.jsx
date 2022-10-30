import { useState } from "react";
import { useDispatch } from "react-redux";
import { ReactSVG } from 'react-svg';
import { Multiselect } from "multiselect-react-dropdown";
import handRight from 'Assets/svg/icons/hand-right.svg';
import Switch from "react-switch";
import { SettingContentWrap } from '../Style';
import api from '../../settingbox/../../helpers/api';


const SettingContent = props => {

    const { optionState, setOptionState } = props;
    const { clintID, nativeLogin, excludedPages, excludedSingle, defaultRole, optionLoader, loader, autoSignIn, redirectUrl, context, cancelOnTapOutside, parentDomain, delay, updateExistingUser } = optionState;
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
                clintID: typeof(options['clintID']) !== 'undefined' ? options['clintID'] : '',
                nativeLogin: typeof(options['nativeLogin']) !== 'undefined' ? options['nativeLogin'] : false,
                excludedPages: typeof(options['excludedPages']) !== 'undefined' ? options['excludedPages'] : [],
                excludedSingle: typeof(options['excludedSingle']) !== 'undefined' ? options['excludedSingle'] : [],
                defaultRole: typeof(options['defaultRole']) !== 'undefined' ? options['defaultRole'] : 'subscriber',
                autoSignIn: typeof(options['autoSignIn']) !== 'undefined' ? options['autoSignIn'] : true,
                redirectUrl: typeof(options['redirectUrl']) !== 'undefined' ? options['redirectUrl'] : '',
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


    const handleLoginPageToggle = (e) => { 
        setOptionState({
            ...optionState,
            nativeLogin: !nativeLogin,
        });
    }

    const handleclintID = (e) => { 
        setOptionState({
            ...optionState,
            clintID: e.target.value
        });

    }
    const handleExcludedPages = ( selectedList, selectedItem ) => { 
        setOptionState({
            ...optionState,
            excludedPages: selectedList
        });

    }

    const handlEexcludedSingle = ( selectedList, selectedItem ) => { 
        setOptionState({
            ...optionState,
            excludedSingle: selectedList
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
            autoSignIn: !autoSignIn,
        });
    }
    const handleRedirect = (e) => { 
        setOptionState({
            ...optionState,
            redirectUrl: e.target.value
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

    // console.log( nativeLogin );
    const SettingContentData = [
        {
            key: "general",
            content: [
                {
                    label: "Google clint ID",
                    component: <div className="exlac-vm-form-group">
                        <input type="text" name="clintID" className="exlac-vm-form__element" id="exlac-vm-chat-btn-text" value={clintID} onChange={handleclintID} />
                        <span className="exlac-vm-setting-has-info__text">Find your clint ID for <a className="exlac-vm-setting-info" target="_blank" href="https://developers.google.com/identity/gsi/web/guides/get-google-api-clientid"><span className="exlac-vm-setting-has-info__text">FREE</span></a>. Follow the <a className="exlac-vm-setting-info" target="_blank" href="https://youtu.be/qS4dY7syQwA?t=471"><span className="exlac-vm-setting-has-info__text">Tutorial</span></a></span>
                    </div>
                },
                {
                    label: "Show in native login page",
                    component: <div className="exlac-vm-setting-has-info">
                        <Switch uncheckedIcon={false} checkedIcon={false} onColor="#6551F2" offColor="#E2E2E2" className="exlac-vm-switch" handleDiameter={14} height={22} width={40} name="nativeLogin" checked={nativeLogin} onChange={handleLoginPageToggle} />
                        <a className="exlac-vm-setting-info" target="_blank" href="https://exlac.com/wp-login.php"><ReactSVG src={handRight} /> <span className="exlac-vm-setting-has-info__text">See, what would it look like!</span></a>
                    </div>
                },
                {
                    label: "Exclude pages",
                    pro: true,
                    component: <Multiselect selectedValues={excludedPages} onSelect={handleExcludedPages} placeholder="Select Pages" options={searchAlert_SettingsScriptData.wp_pages} displayValue="title" />
                },
                {
                    label: "Exclude in single post page",
                    component: <Multiselect selectedValues={excludedSingle} onSelect={handlEexcludedSingle} placeholder="Select Post Types" options={searchAlert_SettingsScriptData.wp_post_types} displayValue="title" />
                },
                {
                    label: "Default user role",
                    pro: true,
                    component: <Multiselect selectedValues={defaultRole} onSelect={handlDefaultRole} placeholder="Select User Role" singleSelect={true} options={searchAlert_SettingsScriptData.wp_roles} displayValue="title" />
                },
                {
                    label: "Auto signin",
                    component: <div className="exlac-vm-setting-has-info">
                        <Switch uncheckedIcon={false} checkedIcon={false} onColor="#6551F2" offColor="#E2E2E2" className="exlac-vm-switch" handleDiameter={14} height={22} width={40} name="autoSignIn" checked={autoSignIn} onChange={handleAutoSignIn} />
                        <span className="exlac-vm-setting-has-info__text">Users don't need to remember which Google Account they selected during their last visit.</span>
                    </div>
                },
                {
                    label: "Redirect URL",
                    pro: true,
                    component: <div className="exlac-vm-form-group">
                        <input type="url" name="redirectUrl" className="exlac-vm-form__element" id="exlac-vm-chat-btn-text" value={redirectUrl} onChange={handleRedirect} />
                    </div>
                },
                {
                    label: "Signin context",
                    pro: true,
                    component: <Multiselect selectedValues={context} onSelect={handlContext} placeholder="Select Context" singleSelect options={searchAlert_SettingsScriptData.context} displayValue="title" />
                },
                {
                    label: "Toggle outside tap to close One Tap",
                    component: <div className="exlac-vm-setting-has-info">
                        <Switch uncheckedIcon={false} checkedIcon={false} onColor="#6551F2" offColor="#E2E2E2" className="exlac-vm-switch" handleDiameter={14} height={22} width={40} name="cancelOnTapOutside" checked={cancelOnTapOutside} onChange={handleCancelOnTapOutside} />
                    </div>
                },
                {
                    label: "Add sub-domain support",
                    pro: true,
                    component: <div className="exlac-vm-form-group">
                        <input type="text" name="parentDomain" className="exlac-vm-form__element" id="exlac-vm-chat-btn-text" value={parentDomain} onChange={handleParentDomain} />
                        <span className="exlac-vm-setting-has-info__text">Use your parent domain like <code>parent-domain.com</code>, Keep blank if you haven't sub-domain installation.</span>
                    </div>
                },
                {
                    label: "Delay to show popup (in seconds)",
                    pro: true,
                    component: <div className="exlac-vm-form-group">
                        <input type="number" name="delay" className="exlac-vm-form__element" id="exlac-vm-chat-btn-text" value={delay} onChange={handleDelay} />
                    </div>
                },
                {
                    label: "Update existing user data",
                    component: <div className="exlac-vm-setting-has-info">
                        <Switch uncheckedIcon={false} checkedIcon={false} onColor="#6551F2" offColor="#E2E2E2" className="exlac-vm-switch" handleDiameter={14} height={22} width={40} name="updateExistingUser" checked={updateExistingUser} onChange={handleUpdateExistingUser} />
                        <span className="exlac-vm-setting-has-info__text">Update First, Last, Display & Nick Name according to Google profile.</span>
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