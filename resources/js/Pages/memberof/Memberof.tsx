import './style.css';
import { elementTrigger, sendInvitation } from './external_function.ts';
import axios from 'axios';
import { Head } from '@inertiajs/react';
import { useMemo } from "react";
import Navbar from '../../Components/Navbar';
import Table from './TableData';
import SU from '../../Components/ModalTableSearchUser';
import FAB from '../../Components/FloatingActionButton';
import { block, For } from 'million/react';

export default function Memberof({ isLogin, iduser, membership, name, notif, nav_active }) {

    elementTrigger();
    const memoName:any = useMemo(() => {
        const cache = name;
        return cache;
    }, [name]); 

    const memoMembership:any = useMemo(() => {
        const cache = membership;
        return cache;
    }, [membership]); 

    const BlockHeadtitle = block(function Lion() {
        return <Head title={`${memoName}'s Membership`} />;
    });
    

    $('#searchuser').keyup(async function(event:any){
        if (event.keyCode === 13) {
            event.preventDefault(); // Menghindari pengiriman form saat menekan tombol Enter
            return;
        }

        const search = $('#searchuser').val();
        const route = `api/user/find/${iduser}/${search}`;
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
                                .click((event) => sendInvitation(event, iduser, id))
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

    const groupSize = 4; // Jumlah item dalam setiap grup
    const groupedData: any[] = [];
    let group: any[] = [];

    if(membership != 0) {
        membership.forEach((item:any, index:number) => {
            if (index > 0 && index % groupSize === 0) {
                groupedData.push(group);
                group = [];
            }
            group.push(item);
        });
    }


    // Tambahkan grup terakhir ke groupedData
    if (group.length > 0) {
        groupedData.push(group);
    }

    const memoGroupedData:any = useMemo(() => {
        const cache = groupedData;
        return cache;
    }, [groupedData]); 

    // console.log(groupedData[0]);

    return (
        <>
        <BlockHeadtitle />
        <Navbar isLogin={isLogin} title="Membership" username={name} notifications={notif} nav_active={nav_active} />

        <div className="p-30 text-is-black">
            <FAB name={'join-membership'} />

            {memoMembership.length > 0 ? (
                <Table groupedData={memoGroupedData} />
            ) : (
                <div className="m-t-0">
                    Not In Membership
                </div>
            )}
        </div>

        <SU name={'join-membership'} title="Add Membership" />
        </>
    )
}
