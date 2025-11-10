"use client";

import { Header } from "@/components/Header";
import { OnboardContainer } from "@/components/OnboardContainer";
import { useEffect } from "react";
import { useLoading } from "../context/LoadingContext";

export default function Home() {
    const {open, close} = useLoading();

    useEffect(() => {
    const fetchData = async () => {
        open(); 
        await new Promise((resolve) => setTimeout(resolve, 2000)); 
        close(); 
    };
    fetchData();
    }, [open, close]);

    return (
        <div className="flex flex-col gap-36
        GeneralPurposeBg min-h-screen ">
            <Header/>
            <OnboardContainer />
        </div>
    )
}