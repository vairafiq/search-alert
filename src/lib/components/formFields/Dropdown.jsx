import { useState, useRef, useEffect } from "react";
import { useDispatch } from 'react-redux';
import { ReactSVG } from 'react-svg';
import { handleTagEdit, handleTagModal, handleDeleteConfirmationModal } from 'MessengerApps/chatDashboard/store/tags/actionCreator';

const Dropdown = ({ selectable, dropdownText, dropdownSelectedText, textIcon, dropdownIconOpen, dropdownIconClose, dropdownList }) => {
    const ref = useRef(null);
    const [state, setState] = useState({
        openDropdown: false,
    });

    /* State Distructuring */
    const { openDropdown } = state;

    const [selectedState, setSelectedState] = useState({
        selectedItemText: dropdownList[0].text,
    });

    const { selectedItemText } = selectedState;

    /* Dispasth is used for passing the actions to redux store  */
    const dispatch = useDispatch();

    /* Handle Dropdown active inactive */
    const handleDropdown = (event) => {
        event.preventDefault();
        const allUserMedia = document.querySelectorAll(".exlac-vm-usermedia");

        setState({
            openDropdown: !openDropdown
        });



        allUserMedia.forEach(medaiItem => {
            medaiItem.classList.remove(".exlac-vm-active");
        });

        if (!openDropdown) {
            event.target.closest('.exlac-vm-usermedia') ? event.target.closest('.exlac-vm-usermedia').classList.add('exlac-vm-active') : '';
        } else {
            event.target.closest('.exlac-vm-usermedia') ? event.target.closest('.exlac-vm-usermedia').classList.remove('exlac-vm-active') : '';
        }
    }

    /* Handle Dropdown Trigger */
    const handleDropdownTrigger = (event, btnName) => {
        event.preventDefault();
        setSelectedState({
            selectedItemText: event.target.text
        });
        switch (btnName) {
            case 'mark-read':
                break;
            case 'tags':
                dispatch(handleTagModal(true));
                break;
            case 'delete-conv':
                dispatch(handleDeleteConfirmationModal(true));
                break;
            case 'edit':
                dispatch(handleTagEdit(true, {}));
                break;
            case 'delete':
                break;
            default:
                break;
        }
    }

    /* Handle the open close dropdown icon */
    const renderDropdownIcon = () => {
        if (openDropdown) {
            return dropdownIconOpen ? <ReactSVG src={dropdownIconOpen} /> : ''

        } else {
            return dropdownIconClose ? <ReactSVG src={dropdownIconClose} /> : ''
        }
    }

    /* Focus Input field when search inopen */
    useEffect(() => {
        const checkIfClickedOutside = e => {

            if (openDropdown && ref.current && !ref.current.contains(e.target)) {
                setState({
                    openDropdown: false
                });
            }
        }
        document.addEventListener("mousedown", checkIfClickedOutside)
        return () => {
            // Cleanup the event listener
            document.removeEventListener("mousedown", checkIfClickedOutside)
        }
    }, [openDropdown]);


    return (
        <div className={selectable ? `${openDropdown ? 'exlac-vm-dropdown exlac-vm-dropdown-selectable exlac-vm-dropdown-open' : 'exlac-vm-dropdown exlac-vm-dropdown-selectable'}` : `${openDropdown ? 'exlac-vm-dropdown exlac-vm-dropdown-open' : 'exlac-vm-dropdown'}`} ref={ref}>
            <a href="#" className={dropdownText ? "exlac-vm-dropdown__toggle" : `${selectable ? "exlac-vm-dropdown__toggle" : "exlac-vm-dropdown__toggle exlac-vm-dropdown__toggle-icon-only"}`} onClick={handleDropdown}>
                {
                    dropdownText ?
                        <span className="exlac-vm-dropdown__toggle--text">
                            {
                                textIcon ? <ReactSVG src={textIcon} /> : ''
                            }
                            <span className="exlac-vm-dropdown__toggle--text-content">Filter by <span className="exlac-vm-selected">unread</span></span>
                        </span> : ""
                }

                {
                    dropdownSelectedText ?
                        <span className="exlac-vm-dropdown__toggle--text">
                            {
                                textIcon ? <ReactSVG src={textIcon} /> : ''
                            }
                            <span className="exlac-vm-dropdown__toggle--text-content">{selectedItemText}</span>
                        </span> : ""

                }

                {
                    renderDropdownIcon()
                }

            </a>
            <ul className={openDropdown ? "exlac-vm-dropdown__content exlac-vm-show" : "exlac-vm-dropdown__content"}>
                {
                    dropdownList.map((item, i) => {
                        return (
                            <li key={i}>
                                <a href="#" onClick={(e) => handleDropdownTrigger(e, item.name)}>{item.icon ? <div className="exlac-vm-dropdown-item-icon"><ReactSVG src={item.icon} /></div> : ''}{item.text}</a>
                            </li>
                        );
                    })
                }
            </ul>
        </div>
    );
};

export default Dropdown;