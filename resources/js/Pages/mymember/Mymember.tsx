import './treeview.css';
import { treeview, elementTrigger, getAllMember,
         sendInvitation, deleteMember } from './external_function.ts';
import axios from 'axios';
import { Head } from '@inertiajs/react';
import { useState, useEffect, useMemo } from "react";
import Navbar from '../../Components/Navbar';
import Table from './TableData';
import Child from './TableChildData';
import SU from '../../Components/ModalTableSearchUser';
import FAB from '../../Components/FloatingActionButton';
import { block, For } from 'million/react';

export default function Mymember({ isLogin, iduser, name, member, notif, nav_active }) {

    treeview();
    elementTrigger();
    const memoName = useMemo(() => {
        const cache = name;
        return cache;
    }, [name]);

    const memoMember = useMemo(() => {
        const cache = member;
        return cache;
    }, [member]);

    const BlockHeadtitle = block(function Lion() {
        return <Head title={`${memoName}'s Member`} />;
    });

    $('#searchuser').keyup(async function(event:any){
        if (event.keyCode === 13) {
            event.preventDefault(); // Menghindari pengiriman form saat menekan tombol Enter
            return;
        }

        const search = $('#searchuser').val();
        const route = `api/user/find/${iduser}/${search}`;
        console.log('route', route);
        try {
            const response = await axios.get(route);
            const res_search = response.data.data;

            $('#searchbody').empty(); // Kosongkan isi tabel sebelum mengisi dengan data baru

            for(let x = 0; x < res_search.length; x++) {
                const id    = res_search[x].id;
                const email = res_search[x].email;
                const name  = res_search[x].name;

                const button = $('<button>')
                                .addClass('button is-fullwidth is-link')
                                .attr('id', `btn-search-user-${email}`)
                                .val(email)
                                .click((event2:any) => sendInvitation(event2, iduser, id))
                                .attr('title', 'Send Invitation')
                                .html('<ion-icon name="person-add-outline"></ion-icon>');

                const tdName = $('<td>').text(name);
                const tdButton = $('<td>').append(button);

                const tr = $('<tr>').append(tdName, tdButton);

                $('#searchbody').append(tr);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });

    const [modal_member_title, setModal_member_title] = useState('');
    const memoModal_member_title = useMemo(() => {
        const cache = modal_member_title;
        return cache;
    }, [modal_member_title]);

    function openModal(event: any, id: Number, name: String) {
        event.preventDefault();

        $(`#modal-member`).addClass('is-active');
        setModal_member_title(name);
        fetchModalMemberData(event, id);
        fetchModalMembershipData(event, id);

        // console.log('modal_member_title', modal_member_title);
        // console.log('modalMembershipdata', modalMembershipdata);
    }

    $('.close-modal-member').click(function(){
        $('#modal-member').removeClass('is-active');
    });

    const [modalMemberdata, setModalMemberData] = useState([]);
    const memoModalmemberdata = useMemo(() => {
        const cache = modalMemberdata;
        return cache;
    }, [modalMemberdata]);

    const [modalMembershipdata, setModalMembershipData] = useState([]);
    const memoModalmembershipdata = useMemo(() => {
        const cache = modalMembershipdata;
        return cache;
    }, [modalMembershipdata]);

    const fetchModalMemberData = async (event: any, id: Number) => {
        event.preventDefault();
        const response = await axios.get(`../api/member/all/${id}`);
        setModalMemberData(response.data.data);
        // console.log(`modalMemberdata ${id}`, memoModalmemberdata);
    };

    const fetchModalMembershipData = async (event: any, id: Number) => {
        event.preventDefault();
        const response = await axios.get(`api/membership/all/${id}`);
        setModalMembershipData(response.data.data);
        // console.log(`modalMembershipdata ${id}`, modalMembershipdata);
    };

    useEffect(() => {
        
    }, [memoMember,
        memoModal_member_title,
        memoModalmemberdata,
        memoModalmembershipdata]);

    return (
        <>
        <BlockHeadtitle />
        <Navbar isLogin={isLogin} title="My Member" username={name} notifications={notif} nav_active={nav_active} />

        <div className="p-30 text-is-black">
            <FAB name={'add-member'} />
            <ul className="m-t-0" id="myUL">
                <li><span className="caret bold">Me - {memoName}</span>
                    <ul className="nested">
                        {memoMember.length > 0 ? (
                            // <Table data={memoMember} />
                            <For each={memoMember} memo>{(bodyparent:any, index:number) => 
                                <li key={index}>
                                    {bodyparent.child_member.length > 0 ? (
                                        <span className="caret bold">{bodyparent.member_name} ({bodyparent.email_member})</span>
                                    ) : (
                                        <span className="">{bodyparent.member_name} ({bodyparent.email_member})</span>
                                    )}

                                    <button className="buttontree" id="button-modal-member" onClick={(event) => openModal(event, bodyparent.id_member, bodyparent.member_name)}>
                                        <ion-icon name="eye-outline"></ion-icon>
                                    </button>
                                    <button className="buttontree" id="button-remove-member" onClick={(event) => deleteMember(event, bodyparent.member_name, bodyparent.mid)}>
                                        <ion-icon name="trash-outline"></ion-icon>
                                    </button>

                                    {bodyparent.child_member.length > 0 ? (
                                        <ul className="nested">
                                            {bodyparent.child_member.map((bodychild: object, index2: number) => (
                                                <li key={index2}>
                                                {bodychild.child_member_name} ({bodychild.child_email_member})
                                                </li>
                                            ))}
                                        </ul>
                                    ) : (<span></span>)}
                                    {/* <Child data={body.child_member} /> */}
                                </li>
                            }</For>
                        ) : (
                            <li>No Member</li>
                        )}
                    </ul>
                </li>
            </ul>
        </div>

        <SU name={'add-member'} title="Add Member" />

        <div className="modal" id="modal-member">
            <div className={`modal-background close-modal-member`}></div>
            <div className="modal-card">
                <header className="modal-card-head">
                    <p className="modal-card-title">
                        <h1 className="title text-is-black">{memoModal_member_title}</h1>
                    </p>
                    <button className={`delete close-modal-member`} aria-label="close"></button>
                </header>
                <section className="modal-card-body">
                    <h1 className="title text-is-black bold underline">Membership</h1>
                    {memoModalmembershipdata.length > 0 ? (
                        <For each={memoModalmembershipdata} memo>{(body:any, index:number) => 
                            <span key={index}>{body.membership},</span>
                        }</For>
                    ) : (
                        <span>No Member</span>
                    )}

                    <h1 className="title text-is-black bold underline m-t-30">Member</h1>
                    {memoModalmemberdata.length > 0 ? (
                        memoModalmemberdata.map((body:any, index:number) => (
                            <span key={index}>{body.member_name} ({body.email_member}), </span>
                        ))
                    ) : (
                        <span>No Member</span>
                    )}
                </section>
            </div>
        </div>
        </>
    )
}
