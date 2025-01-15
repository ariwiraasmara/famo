import { Head } from '@inertiajs/react';
import Navbar from '../Components/Navbar';
import ViewLabel from '../Components/ViewLabel';
import { useEffect, useMemo } from "react";
import store from '../store';
import { Provider, useDispatch } from "react-redux";
import { getMymember, getMemberof } from '../actions';
import { block, For, mount } from 'million/react';

export default function Dashboard({ isLogin, name, recent_membership, recent_mymember, notif, nav_active }) {
    
    // const dispatch = useDispatch();
    // useEffect(() => {
    //     dispatch(getMymember());
    //     dispatch(getMemberof());
    // }, []);

    const memoName:any = useMemo(() => {
        const cache = name;
        return cache;
    }, [name]);

    const memoMembership:any = useMemo(() => {
        const cache = recent_membership;
        return cache;
    }, [recent_membership]);

    const numberMembership = () => {
        try {
            return memoMembership.length;
        }
        catch(err) {
            return 0;
        }
    }
    
    const memoMymember:any = useMemo(() => {
        const cache = recent_mymember;
        return cache;
    }, [recent_mymember]);

    const numberMymember = () => {
        try {
            return memoMymember.length;
        }
        catch(err) {
            return 0;
        }
    }

    const BlockHeadtitle = block(function Lion() {
        return <Head title={`Dashboard ${memoName}`} />;
    });

    const BlockName = block((props) => {
        return (
            <h1 className="title text-is-black bold">{props.name}</h1>
        );
    });

    const BlockRecent = block((props) => {
        return (
            <div>
                <span className="bold">{props.label}</span> : {props.number}
            </div>
        );
    });

    const BlockItems = block((props) => {
        return (
            <div className="column is-3" key={props.index}>
                <div className="box word-wrap text-is-black">
                    <span className="bold">{ props.name }</span>
                    ({ props.email })
                </div>
            </div>
        );
    });
      
    return (
        <>
            <BlockHeadtitle />
            <Navbar isLogin={isLogin} title="Dashboard" username={name} notifications={notif} nav_active={nav_active} />
            <div className="p-30 text-is-black">
                <BlockName name={memoName} />

                <div className="m-t-30">
                    <span className="bold underline">Summary</span>
                </div>

                <div className="m-t-10">
                    <BlockRecent label={`Membership`} number={numberMembership()} />
                    <BlockRecent label={`My Member`} number={numberMymember()} />
                </div>

                <div className="m-t-30">
                    <span className="bold underline">Recent Membership</span>

                    {numberMembership() > 0 ? (
                        <div className="m-t-10 columns is-mobile">
                        <For each={memoMembership} memo>{(body1:object, index1:number) => 
                            <BlockItems index={index1} name={body1.membership} email={body1.email_membership} />
                        }</For>
                    </div>
                    ) : (
                        <div className="column is-12">
                            Not In Membership
                        </div>
                    )}
                </div>

                <div className="m-t-30">
                    <span className="bold underline">Recent My Member</span>
                    {numberMymember() > 0 ? (
                        <div className="m-t-10 columns is-mobile">
                        <For each={memoMymember} memo>{(body2:object, index2:number) => 
                            <BlockItems index={index2} name={body2.member_name} email={body2.email_member} />
                        }</For>
                    </div>
                    ) : (
                        <div className="column is-12">
                            No Member
                        </div>
                    )}
                </div>

            </div>
        </>
    );
}
