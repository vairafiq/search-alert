import React, { useState } from 'react';
import { SidebarMenuItem } from '../Style.js';

const NavItem = (menuItem) => {
    const [subnav] = useState(false);
    
    const handleMenu = (e) => {
        e.preventDefault();
    }

    return (
        <SidebarMenuItem className={subnav ? "exlac-vm-sidebar-nav__item exlac-vm-sidebar-nav__submenu-open" : "exlac-vm-sidebar-nav__item"}>
            <a href='#' onClick={handleMenu}>
                <div className="exlac-vm-sidebar-nav__item--icon">{menuItem.item.icon}</div>
                <span className="exlac-vm-sidebar-nav__item--text">
                    {menuItem.item.label}
                    {
                        menuItem.item.subNav && subnav ?
                            menuItem.item.iconOpened
                            : menuItem.item.subNav
                                ? menuItem.item.iconClosed
                                : null
                    }
                </span>
            </a>
            <ul>
                {
                    subnav && menuItem.item.subNav && menuItem.item.subNav.map((subItem, index) => {
                        return (
                            <li key={index}><a href='#'>{subItem.label}</a></li>
                        )
                    })
                }
            </ul>

        </SidebarMenuItem>
    )
}

export default NavItem;