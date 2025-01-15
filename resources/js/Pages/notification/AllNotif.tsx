import './style.css';
import { elementTrigger, confirmation, deleteNotif } from './external_function.ts';
import React, { Head } from '@inertiajs/react';
import Navbar from '../../Components/Navbar';
import store from '../store';
import { Provider, useDispatch } from "react-redux";
import { getMymember, getMemberof } from '../actions';
import { Fragment, useMemo } from 'react';
import { block, For } from 'million/react';

export default function AllNotif({ isLogin, name, notif, allnotif }) {

    console.log('allnotif', allnotif);
    elementTrigger();
    const BlockHeadtitle = block(function Lion() {
        return <Head title={`${name}'s Notification`} />;
    });

    const memoAllnotif:any = useMemo(() => {
        const cache = allnotif;
        return cache;
    }, [allnotif]);

    const BlockLabelNotif = block((props) => {
        return (
            <div>
                <span className="bold">{`#${props.index+1}).`} {props.name}'s </span>
                <span>{props.label}</span>
            </div>
        );
    });

    const BlockButtonConfirmation = block((props) => {
        return (
            <button type="button" 
                    id={props.id}
                    className={props.class}
                    onClick={(event) => confirmation(props.idinvite, props.val, props.iduser)}>
                {props.label}
            </button>
        );
    });

    return(
        <>
            <BlockHeadtitle />
            <Navbar isLogin={isLogin} title="All Notification" username={name} notifications={notif} />

            <div className="p-20 text-is-black">

                <div className="m-b-10 right">
                    <button className="button is-danger is-large">
                        <ion-icon name="checkmark-outline"></ion-icon>
                    </button>
                </div>

                {memoAllnotif.length > 0 ? (
                    <For each={memoAllnotif} memo>{(body:any, index:number) => 
                        <div className="columns is-mobile line-row">
                            <div className="column is-8">
                                {body.type === 'invite' ? (
                                    <BlockLabelNotif 
                                        index={index} 
                                        name={body.name} 
                                        label={`want to invite you to become their member`} />
                                ) : (
                                    <BlockLabelNotif 
                                        index={index} 
                                        name={body.name} 
                                        label={`want to join into you're membership`} />
                                )}
                                {body.is_rejected == 1 ? (
                                    <div className="bold italic underline m-t-10 has-text-info">You have rejected this invitation</div>
                                ) : (
                                    <div className="bold italic underline m-t-10 has-text-info">You have accepted this invitation</div>
                                )}
                            </div>

                            <div className="column is-4 right">
                                {body.date_confirm == null ? (
                                    <div className="columns is-mobile">
                                        <div className="column is-half">
                                            <BlockButtonConfirmation
                                                id={`button-notif-yes`}
                                                class={`button is-success is-fullwidth`}
                                                label={`Yes`}
                                                idinvite={body.idc}
                                                val={1}
                                                iduser={body.id_recipient}
                                            />
                                        </div>
                                        <div className="column is-half">
                                            <BlockButtonConfirmation
                                                id={`button-notif-no`}
                                                class={`button is-warning is-fullwidth`}
                                                label={`No`}
                                                idinvite={body.idc}
                                                val={0}
                                                iduser={body.id_recipient}
                                            />
                                        </div>
                                    </div>
                                ) : (
                                    <button type="button" id="btn-delete-notif"
                                            className="button is-danger is-large "
                                            onClick={() => deleteNotif(body.idc)}>
                                        <ion-icon name="trash-outline" size="medium"></ion-icon>
                                    </button>                                    
                                )}
                            </div>
                        </div>
                    }</For>
                    
                ) : (<div>No Notification</div>)}
            </div>
        </>
    )
}