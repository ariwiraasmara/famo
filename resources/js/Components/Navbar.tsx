import './styles/nav.css';
import { navbar, elementTrigger, confirmation } from './external_functions/ext_nav.ts';
import React, { useState, Fragment, useMemo } from "react";
import { block, For } from 'million/react';

export default function Navbar({ isLogin, title, username, notifications, nav_active }) {
    const memoNav_active:any = useMemo(() => {
        const cache = nav_active;
        return cache;
    }, [nav_active]); 

    if(memoNav_active == 'dashboard') $('#nav-dashboard').addClass('nav-active');
    else if(memoNav_active == 'mymember') $('#nav-mymember').addClass('nav-active');
    else if(memoNav_active == 'memberof') $('#nav-memberof').addClass('nav-active');

    navbar();
    elementTrigger();
    const [isNavNotifboxVisible, setIsNavNotifboxVisible] = useState(false);
    const [isNavUserVisible, setIsNavUserVisible] = useState(false);

    const handleNavNotifClick = () => {
        setIsNavNotifboxVisible(!isNavNotifboxVisible);
        setIsNavUserVisible(false);
    };

    const handleNavProfileClick = () => {
        setIsNavUserVisible(!isNavUserVisible);
        setIsNavNotifboxVisible(false);
    };

    const memoUsername:any = useMemo(() => {
        const cache = username;
        return cache;
    }, [username]); 

    const memoTitle:any = useMemo(() => {
        const cache = title;
        return cache;
    }, [title]); 

    const memoNotifications:any = useMemo(() => {
        const cache = notifications;
        return cache;
    }, [notifications]); 

    const BlockTitle = block((props) => {
        return (
            <a className="m-t-5 m-l-15 title bold text-is-white" href="#welcome">
                {props.title}
            </a>
        );
    });

    const BlockLabelConfirmation = block((props) => {
        return (
            <span>{props.name}'s want to invite you to become their member</span>
        );
    });

    const BlockButtonConfirmation = block((props) => {
        return (
            <button type="button" id={props.id}
                    className={props.class}
                    onClick={() => confirmation(props.idc, props.type, props.id_recipient)}>
                {props.labelyesno}
            </button>
        );
    });

    return (
        <>
        <nav className="navbar is-info" role="navigation" aria-label="main navigation">
            <div className="navbar-brand">
                <BlockTitle title={memoTitle} />

                <a role="button" className="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </a>
            </div>

            <div id="navbarBasicExample" className="navbar-menu">
                {isLogin ? (
                    <Fragment>
                    <div className="navbar-start">
                        <a href="/dashboard" className="navbar-item" id="nav-dashboard">
                            Dashboard
                        </a>

                        <a href="/mymember" className="navbar-item" id="nav-mymember">
                            My Member
                        </a>

                        <a href="/memberof" className="navbar-item" id="nav-memberof">
                            Membership
                        </a>

                        <a href="#about" className="navbar-item is-success" id="about">
                            About
                        </a>
                    </div>

                    <div className="navbar-end">
                        <div className="navbar-item">
                            <div className="buttons">
                                <span href="#notif" className="button is-light" id="nav-notif" onClick={handleNavNotifClick}>
                                    <ion-icon name="notifications-outline"></ion-icon>
                                    {notifications[0] == null ? null : (
                                        <span className="m-l-5">{notifications.length}</span>
                                    )}

                                </span>
                                <span className="button is-primary" id="nav-profile" role="button" onClick={handleNavProfileClick}>
                                    <ion-icon name="person-outline"></ion-icon>
                                </span>
                            </div>
                        </div>
                    </div>
                    </Fragment>
                ) : (
                    <Fragment>
                    <div className="navbar-start">
                        <a href="#register" className="navbar-item is-link" id="register">
                            Register
                        </a>

                        <a href="#login" className="navbar-item is-success" id="login">
                            Log in
                        </a>

                        <a href="#about" className="navbar-item is-success" id="about">
                            About
                        </a>
                    </div>
                    </Fragment>
                )}
            </div>
        </nav>

        <aside className={`notifbox ${isNavNotifboxVisible ? '' : 'hide'}`} id="nav-notifbox">
            <ul className="m-l-r-10">
                {memoNotifications.length > 0 ? (
                    <For each={memoNotifications.slice(0, 9)} memo>{(body:any, index:number) =>
                        <Fragment>
                        <li>
                            <div className="columns is-mobile is-desktop">
                                <div className="column is-8">
                                    {body.type == 'invite' ? (
                                        <BlockLabelConfirmation name={body.name} />
                                        // <span>{body.name}'s want to invite you to become their member</span>
                                    ) : (
                                        <BlockLabelConfirmation name={body.name} />
                                        // <span>{body.name}'s want to join into you're membership</span>
                                    )}
                                </div>

                                <div className="column is-4">
                                    <div className="columns is-mobile">
                                        <div className="column is-half">
                                            <BlockButtonConfirmation 
                                                id={`btn-nav-confirmation-yes-${index}`} 
                                                class={`button is-success is-fullwidth`}
                                                idc={body.idc} 
                                                type={1} 
                                                id_recipient={body.id_recipient}
                                                labelyesno={`Y`} />
                                        </div>
                                        <div className="column is-half">
                                            <BlockButtonConfirmation 
                                                id={`btn-nav-confirmation-no-${index}`} 
                                                class={`button is-warning is-fullwidth`}
                                                idc={body.idc} 
                                                type={0} 
                                                id_recipient={body.id_recipient}
                                                labelyesno={`N`} />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li className="separate"></li>
                        </Fragment>
                    }</For>
                ) : (<span></span>)
                }
                <li className="m-b-10">
                    <a href="/notification/all">
                        <span className="has-text-link">View All Notification</span>
                        {memoNotifications.length > 0 ? (
                            memoNotifications.length > 9 ? (
                                <span className="button is-small is-link m-l-10">9+</span>
                            ) : (
                                <span></span>
                            )
                        ) : (<span></span>)}
                    </a>
                </li>
            </ul>
        </aside>

        <aside className={`userbox ${isNavUserVisible ? '' : 'hide'}`} id="nav-user">
            <ul className="m-l-r-10">
                <li><a href="/profile">{memoUsername}</a></li>
                <li className="separate"></li>
                <li className="m-b-10"><a href="/logout">Logout</a></li>
            </ul>
        </aside>

        <div className="modal" id="modal-about">
            <div className="modal-background close-modal-about"></div>
            <div className="modal-card">
                <header className="modal-card-head">
                    <p className="modal-card-title">
                        <h1 className="title">About</h1>
                    </p>
                    <button className="delete close-modal-about" aria-label="close"></button>
                </header>
                <section className="modal-card-body justify text-is-black">
                    <span className="bold">Family Organization</span> adalah sebuah aplikasi berbasis Social Media dimana para pengguna dapat menambahkan anggota dan keanggotaan mereka berbasis organisasi, dengannya mereka dapat melihat dan mengetahui anggota keanggotaannya dan anggota anggotanya.

                    <br/><br/><span className="bold">Copyright @ Syahri Ramadhan Wiraasmara (ARI)</span>
                </section>
            </div>
        </div>
        </>
    );
}
